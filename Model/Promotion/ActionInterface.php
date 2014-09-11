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

    /**
     * checks the eligibility of cart
     *
     * @param Cart $cart
     * @return either true or false
     */
    public function isEligible(Cart $cart);
}
