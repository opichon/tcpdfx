<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCart;

class Cart extends BaseCart
{
    const OPEN = 0;
    const PROCESSED = 1;
    const PAID = 2;

    const APPROVED = 3;
    const SHIPPED = 4;
    const CLOSED = 8;

    const PACKED = 16;

    const ERROR = 256;

    const RETURNED = 800;
    const CANCELLED = 801;

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
