<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;

interface RuleInterface
{
    /**
     * checks the eligibility of cart
     *
     * @param Cart $cart
     * @return either true or false
     */
    public function isEligible(Cart $cart);
}
