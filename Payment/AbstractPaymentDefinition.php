<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

class AbstractPaymentDefinition implements PaymentDefinition
{
	const PAYMENT_TYPE_ID = 0;

	const CLASS_NAME = 'Dzangocart\Bundle\CoreBundle\Model\Payment';

	public function getClassKey()
    {
        return static::PAYMENT_TYPE_ID;
    }

    public function getClassName()
    {
        return static::CLASS_NAME;
    }
}