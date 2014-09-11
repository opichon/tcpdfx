<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;

class FreeItemAction extends Action implements ActionInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setClassKey(ActionPeer::CLASSKEY_1);
    }

    public function execute(Cart $cart, Promotion $promotion)
    {
    }

    public function isEligible(Cart $cart)
    {
    }
}
