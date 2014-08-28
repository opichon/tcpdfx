<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCart;

class Cart extends BaseCart
{
    const STATUS_OPEN = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_PAID = 2;

    const STATUS_APPROVED = 3;
    const STATUS_SHIPPED = 4;
    const STATUS_CLOSED = 8;

    const STATUS_PACKED = 16;

    const STATUS_ERROR = 256;

    const STATUS_RETURNED = 800;
    const STATUS_CANCELLED = 801;

    public function getAmountIncl()
    {
        return $this->getCurrency()->format(parent::getAmountIncl());
    }

    public function getAmountExcl()
    {
        return $this->getCurrency()->format(parent::getAmountExcl());
    }

    public function getTaxAmount()
    {
        return $this->getCurrency()->format(parent::getTaxAmount());
    }

    public function getAmountPaid()
    {
        $payments = $this->getPayments();

        $total = 0;

        foreach ($payments as $payment) {
              $total += $payment->getAmount();
        }

        return $this->getCurrency()->format($total);
    }

    public function isPaid()
    {
        return $this->getStatus() & self::STATUS_PAID;
    }

    public function isCredit()
    {
        return $this->getAmountExcl() < 0;
    }

    public function isCancelled()
    {
        // TODO
        return false;
    }

    public function isCancellation()
    {
        // TODO
        return false;
    }

    public function addNewItem($category, $name, $price, $quantity, $code, Options $options)
    {
        return $category->addItemToCart($this, $name, $price, $quantity,$code, $options);
    }

    /**
     *
     *  @return the sum of quantity of item for cart
     */
    public function getQuantity(Category $category, $code = null)
    {
        $query = ItemQuery::create()
            ->filterByCart($this)
            ->filterByCategory($category)
            ->filterByDeletedAt(null, Criteria::ISNULL);

        if ($code) {
            $query->filterByCode($code, Criteria::LIKE);
        }

        $item = $query->withColumn('SUM(item.quantity)', 'cartQuantity')
            ->findOne();

        return $item->getCartQuantity() ? $item->getcartQuantity() : 0;
    }

    public function getItem(Category $category, $name = null, $code = null, $price = null)
    {
        $query = ItemQuery::create()
            ->filterByCategory($category)
            ->filterByOrderId($this->getId());

        if ($name) {
            $query->filterByName($name);
        }

        if ($code) {
            $query->filterByCode($code);
        }

        return $query->findOne();
    }

    public function updateAmounts()
    {
//        if ($items = $this->getItems()) {
//            $amount_excl = 0;
//            $tax_amount = 0;
//
//            foreach ($items as $item) {
//                $amount_excl += $item->getAmountExcl();
//                $tax_amount += $item->getTaxAmount();
//            }
//
//            $this->setAmountExcl($amount_excl);
//            $this->setTaxAmount($tax_amount);
//            $this->setAmountIncl($amount_excl + $tax_amount);
//
//            if ($this->isCredit()) {
//                $credit_amount = $this->getAmountIncl();
//            } else {
//                $credit_amount = min(
//                    array(
//                        $this->getAmountIncl(),
//                        $this->getCustomer() ? $this->getCustomer()->getCreditBalance() : 0
//                    )
//                );
//            }
//
//            $this->setCreditAmount($credit_amount);
//        }
    }
}
