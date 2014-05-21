<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BasePaymentPeer;
use Dzangocart\Bundle\CoreBundle\Payment\PaymentClassRegistry;
class PaymentPeer extends BasePaymentPeer
{
    public static function getOMClass($row = 0, $colnum = 0)
    {
        $om_class = null;
        $class_key = $row[$colnum + 3];

        $om_class = PaymentClassRegistry::getInstance()
            ->getPaymentClass($class_key);

        return $om_class;
    }
}
