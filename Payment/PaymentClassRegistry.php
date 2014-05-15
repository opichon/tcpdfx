<?php

namespace Dzangocart\Bundle\CoreBundle\Payment;

use Dzangocart\Bundle\CoreBundle\Error\Payment\DuplicateClassKeyException;
use Dzangocart\Bundle\CoreBundle\Error\Payment\InvalidClassException;
use Dzangocart\Bundle\CoreBundle\Error\Payment\UnknownClassKeyException;


class PaymentClassRegistry
{
    private static $instance = null;

    private $registry ;

    //Prevent any oustide instantiation of this class.
    private function __construct()
    {
        $this->registry = array();
    }

    //Prevent any copy of this object
    private function __clone()
    {
    }

    /**
     * Singleton pattern.
     *
     * @return PaymentClassRegistry
     */
    public static function getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new PaymentClassRegistry();
        }

        return self::$instance;
    }

    /**
     * Registers the class name from the payment definition against its class_key
     *
     * @throws Dzangocart\Bundle\CoreBundle\Error\Payment\DuplicateClassKeyException
     *             if the class key is already defined
     * @throws Dzangocart\Bundle\CoreBundle\Error\Payment\InvalidClassExpceiton
     *            if the class does not implement the Dzangocart\Bundle\CoreBundle\Payment\Payment
     *             interface
     */
    public function register(PaymentDefinition $payment_definition)
    {
        $class_key = $payment_definition->getClassKey();

        $classname = $payment_definition->getClassName();

        if (!in_array($class_key, $this->registry)) {

            $obj_class = new $classname();

            if (!$obj_class instanceof Payment) {
                throw new InvalidClassException();
            }

            $this->registry[$class_key] = $classname;

        } else {
            throw  new DuplicateClassKeyException();

        }
    }

    /**
     * Returns a payment class name based ont he supplied class key
     *
     * @throws Dzangocart\Bundle\CoreBundle\Error\Payment\UnknownClassKeyException if
     *             no class is registered under the supplied class key,
     */
    public function getPaymentClass($class_key)
    {
        $payment_class = null;

        if (array_key_exists($class_key, $this->registry)) {

            $payment_class = $this->registry[$class_key];
        } else {
            throw new UnknownClassKeyException();
        }

        return $payment_class;
    }
}
