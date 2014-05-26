<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

class AbstractPaymentDefinition implements PaymentDefinition
{
	const PAYMENT_TYPE_ID;

	const CLASS_NAME;

	public function getClassKey()
    {
        return static::PAYMENT_TYPE_ID;
    }

    public function getClassName()
    {
        return static CLASS_NAME;
    }
}