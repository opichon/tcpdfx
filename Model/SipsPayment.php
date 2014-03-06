<?php

namespace Dzangocart\Bundle\CoreBundle\Model;



/**
 * Skeleton subclass for representing a row from one of the subclasses of the 'payment' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.vendor.dzangocart.core-bundle.Dzangocart.Bundle.CoreBundle.Model
 */
class SipsPayment extends Payment {

    /**
     * Constructs a new SipsPayment class, setting the type_id column to PaymentPeer::CLASSKEY_2.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTypeId(PaymentPeer::CLASSKEY_2);
    }

} // SipsPayment
