<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

class PaymentClassRegistry
{
	/**
	 * Singleton pattern.
	 *
	 * @return PaymentClassRegistry
	 */
	public static function getInstance()
	{

	}

	/**
	 * Registers the class name from the payment definition against its class_key
	 *
	 * @throws Dzangocart\Bundle\CoreBundle\Error\Payment\DuplicateClassKeyException
	 * 			if the class key is already defined
	 * @throws Dzangocart\Bundle\CoreBundle\Error\Payment\InvalidClassExpceiton
	 *			if the class does not implement the Dzangocart\Bundle\CoreBundle\Payment\Payment
	 * 			interface
	 */
	public function register(PaymentDefinition $payment_definition)
	{

	}

	/**
	 * Returns a payment class name based ont he supplied class key
	 *
	 * @throws Dzangocart\Bundle\CoreBundle\Error\Payment\UnknownClassKeyException if
	 * 			no class is registered under the supplied class key,
	 */
	public function getPaymentClass($class_key)
	{

	}
}
