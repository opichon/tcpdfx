<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\Promotion;

interface ActionInterface
{
    /**
     * executes the specific promotion action
     *
     * @param Cart $cart
     * @param Promotion $promotion
     *
     */
    public function execute(Cart $cart, Promotion $promotion);
}
