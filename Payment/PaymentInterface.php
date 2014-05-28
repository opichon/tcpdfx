<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

interface PaymentInterface
{
    public function getClasskey();

    public function getTransaction();

    public function getDate();

    public function getAmount();

    public function getCurrency();
}
