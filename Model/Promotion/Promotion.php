<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;

use Dzangocart\Bundle\CoreBundle\Model\Promotion\om\BasePromotion;

class Promotion extends BasePromotion
{
    public function execute(Cart $cart)
    {
        try {

            $action = $this->getAction();

            $action->execute($cart, $this);

        } catch (Exception $ex) {
            // throw exception
        }
    }
}
