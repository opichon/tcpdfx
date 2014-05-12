<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

interface PaymentDefinition
{
    /**
     * Returns the classkey for the payment class
     *
     * @return int
     */
    public function getClassKey();

    /**
     * Returns the fully-qualified name of the payment class
     *
     * @return string
     */
    public function getClassName();
}
