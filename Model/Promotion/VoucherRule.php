<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;

class VoucherRule extends Rule implements RuleInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setClassKey(RulePeer::CLASSKEY_1);
    }

    public function isEligible(Cart $cart)
    {
        return true;
    }
}
