<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;


class VoucherRule extends Rule
{
    public function __construct()
    {
        parent::__construct();
        $this->setClassKey(RulePeer::CLASSKEY_1);
    }
}
