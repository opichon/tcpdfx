<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

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
        return $this->getStatus() & self::PAID;
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
}
