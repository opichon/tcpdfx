<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BasePaymentPeer;

class PaymentPeer extends BasePaymentPeer
{
    protected static $registry = array();
    
    public static function registerClass($class_key, $classname)
    {
        if(!in_array($class_key, self::$registry)) {
            
            self::$registry[$class_key] = $classname;
            
        } else {
            
            throw  new \PropelException('already exists!!');
            
        }
        
    }
    
    public static function getOMClass($row = 0, $colnum = 0)
    {
        try {

            $omClass = null;
            $classKey = $row;

            switch ($classKey) {

                case Payment::TYPE_PP_DIRECT:
                    $omClass = self::$registry[Payment::TYPE_PP_DIRECT];
                    break;

                case Payment::TYPE_SIPS:
                    $omClass = self::$registry[Payment::TYPE_SIPS];
                    break;

                case Payment::TYPE_PO:
                    $omClass = self::$registry[Payment::TYPE_PO];
                    break;

                case Payment::TYPE_PP_EXPRESS:
                    $omClass = self::$registry[Payment::TYPE_PP_EXPRESS];
                    break;

                default:
                    $omClass = PaymentPeer::OM_CLASS;

            } // switch

        } catch (Exception $e) {
            throw new PropelException('Unable to get OM class.', $e);
        }

        return $omClass;
    }
}
