<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\om\BaseRule;

class Rule extends BaseRule implements RuleInterface
{
    public function isEligible(Cart $cart, Promotion $promotion)
    {
    }
}
