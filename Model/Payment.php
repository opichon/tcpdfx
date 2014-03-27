<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BasePayment;

class Payment extends BasePayment
{
    const PAYMENT_TYPE_ID = 0;

    const TYPE_PP_DIRECT     = 1;
    const TYPE_SIPS          = 2;
    const TYPE_PO            = 4;
    const TYPE_PP_EXPRESS    = 5;

    const STATUS_OPEN      = 0;
    const STATUS_CANCELLED = 2;
    const STATUS_ERROR     = 4;
    const STATUS_APPROVED  = 8;
    const STATUS_PAID      = 16;

    public function isOpen()
    {
        return $this->getStatus() == self::STATUS_OPEN;
    }

    public function isPaid()
    {
        return $this->getStatus() & self::STATUS_PAID;
    }

    public function setPaid()
    {
        if ($this->isOpen() || $this->isApproved()) {
             $this->setStatus($this->getStatus() | (self::STATUS_PAID | self::STATUS_APPROVED));
        }
    }

    public function isApproved()
    {
        return $this->getStatus() & self::STATUS_APPROVED;
    }

    public function approve()
    {
        if (!$this->isOpen()) {
            return;
        }

        $this->setStatus($this->getStatus() | self::STATUS_APPROVED);
    }

    public function isCancelled()
    {
        return $this->getStatus() & self::STATUS_CANCELLED;
    }

    public function cancel()
    {
        if (!$this->isOpen()) {
            return;
        }

        $this->setStatus($this->getStatus() | self::STATUS_CANCELLED);
    }

    public function isError()
    {
        return $this->getStatus() & self::STATUS_ERROR;
    }

    // [TODO OP 2009-08-11] revisit: an approved payment may be set to error
    public function setError()
    {
        if (!$this->isOpen()) {
            return;
        }

        $this->setStatus($this->getStatus() | self::STATUS_ERROR);
    }
    public function getClassKey()
    {
        return static::PAYMENT_TYPE_ID;
    }

    public function getAmount()
    {
        return $this->getTransaction()->getAmount();
    }

    public function getCurrency()
    {
        return $this->getTransaction()->getCurrency();
    }

    public function getCurrencyId()
    {
        return $this->getCurrency()->getId();
    }

    public function getDescription()
    {
         return $this->getTransaction()->getDescription();
    }
}
