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
        try {

            $rule = $promotion->getRule();

            if ($rule->isEligible($cart)) {
                $this->cancel($cart, $promotion);
                $this->createItem($cart, $promotion);
            } else {
                $this->cancel($cart, $promotion);
            }

        } catch (Exception $ex) {
            // throw exception
        }

        return $cart;
    }

    public function cancel(Cart $cart, Promotion $promotion)
    {
        $item = $this->getPromotionItem($cart, $promotion);

        if ($item) {
            // $cart->remove($item);
        }

        return $cart;
    }

    protected function getPromotionItem(Cart $cart, Promotion $promotion)
    {
    }

    protected function createItem(Cart $cart, Promotion $promotion)
    {
    }

    protected function createSubItem(Item $item)
    {
    }
}
