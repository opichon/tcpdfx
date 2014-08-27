<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseItem;

class Item extends BaseItem
{
    public function getOrder()
    {
        return $this->getCart();
    }

    public function addQuantity($quantity)
    {
        $this->setQuantity($this->getQuantity() + $quantity);
    }

    public function setPrice($price)
    {
        if ($this->getTaxIncluded()) {
            $this->setPriceIncl($price);
        } else {
            $this->setPriceExcl($price);
        }

        $this->updateAmount();
    }

    public function getItems()
    {
        return iterator_to_array($this->getItemsRelatedById(null));
    }

    public function isTaxIncluded()
    {
        return $this->getTaxIncluded();
    }

    public function isCredit()
    {
        return $this->getCredit();
    }

    public function updateAmount($updateOrder = true)
    {
        if ($items = $this->getItems()) {
            $amount_excl = 0;
            $tax_amount = 0;

            foreach ($items as $item) {
                if (is_null($item->getAmountIncl())) {
                    $item->updateAmounts(false);
                    $item->save();
                }

                $amount_excl += $item->getAmountExcl();
                $tax_amount += $item->getTaxAmount(false);
            }

            $this->setAmountExcl($amount_excl);
            $this->setTaxAmount($tax_amount);
            $this->setAmountIncl($amount_excl + $tax_amount);

        } elseif ($this->quantity) {
            if ($this->isTaxIncluded() && !is_null($this->price_incl)) {
                $this->setAmountIncl(($this->isCredit() ? -1 : 1) * round($this->quantity * $this->price_incl, 2));
                $this->setTaxAmount(round($this->amount_incl * $this->getTaxRate() / (100 + $this->getTaxRate()), 2));
                $this->setAmountExcl($this->amount_incl - $this->tax_amount);
            } else {
                $this->setAmountExcl(($this->isCredit() ? -1 : 1) * round($this->quantity * $this->price_excl, 2));
                $this->setTaxAmount(round($this->amount_excl * $this->getTaxRate() / 100, 2));
                $this->setAmountIncl($this->amount_excl + $this->tax_amount);
            }
        }

        if ($updateOrder && ($order = $this->getOrder())) {
            $order->updateAmounts();
        }
    }
}
