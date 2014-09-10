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

            if ($this->isEligible($cart)) {
                // $action->execute($cart, $this);
            } else {
                // $action->cancel($cart, $this)
            }

        } catch (Exception $ex) {
            // throw exception
        }
    }

    public function getAction()
    {
        return ActionQuery::create()
            ->filterById($this->getActionId())
            ->findOne();
    }

    public function isEligible(Cart $cart)
    {
        // TODO: check eligibility of cart;
    }
}
