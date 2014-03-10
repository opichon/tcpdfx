<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BasePaymentPeer;

class PaymentPeer extends BasePaymentPeer
{
    protected static $registry = array();

    public static function registerClass($class_key, $classname)
    {
        if (!in_array($class_key, self::$registry)) {

            self::$registry[$class_key] = $classname;

        } else {

            throw  new \PropelException('already exists!!');

        }

    }

    public static function getOMClass($row = 0, $colnum = 0)
    {
        try {
            $om_class = null;
            $class_key = $row[$colnum + 3];

            if (array_key_exists($class_key, self::$registry)) {

                $om_class = self::$registry[$class_key];
            }

        } catch (Exception $e) {
            throw new PropelException('Unable to get OM class.', $e);
        }

        return $om_class;
    }
}
