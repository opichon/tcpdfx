<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

interface Payment
{
    public function getClasskey();

    public function getTransaction();

    public function getDate();

    public function getAmount();

    public function getCurrency();
}
