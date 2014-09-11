<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\om\BaseAction;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\Promotion;

class Action extends BaseAction implements ActionInterface
{
    public function execute(Cart $cart, Promotion $promotion)
    {
    }

    public function isEligible(Cart $cart)
    {
    }

}
