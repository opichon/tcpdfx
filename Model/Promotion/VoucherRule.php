<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Dzangocart\Bundle\CoreBundle\Model\Cart;

class VoucherRule extends Rule implements RuleInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setClassKey(RulePeer::CLASSKEY_1);
    }

    public function isEligible(Cart $cart, Promotion $promotion)
    {
        // get cart date
        $cart_date = $cart->getUpdatedAt();

        // get promotion valid from
        $promotion_valid_from = $promotion->getDateFrom();

        // get promotion valid to
        $promotion_valid_to = $promotion->getDateTo();

        // get the promotional category
        $category = $promotion->getCategory();

        // check cart is within period of promotion validity
        $isValid_date = ($cart_date >= $promotion_valid_from) && ($cart_date <= $promotion_valid_to);

        // check that cart has category
        // $cart_hasCategory = $category && !$cart->hasCategory($category, true, true);
        $cart_hasCategory = true;

        // verify the rule
        $is_Verified = $this->verify($cart, $promotion->getRuleParam());

        return $isValid_date && $cart_hasCategory && $is_Verified;
    }

    protected function verify(Cart $cart, $rule_param)
    {
        if (!$rule_param) {
            return false;
        }

        return $rule_param == $cart->getVoucher();
    }
}
