<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\Cart;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCustomer;

class Customer extends BaseCustomer
{
    public function getUser()
    {
        return $this
            ->getUserProfile()
            ->getUser();
    }

    public function getName()
    {
        return $this
            ->getUserProfile()
            ->getFullName(true);
    }

    public function getYdtSales()
    {
        $dates = array();

        $dates['min'] = date('Y-01-01') . ' 00:00:00';

        $dates['max'] = date('Y-m-d') . ' 23:59:59';

        $cart = CartQuery::create()
            ->filterByCustomer($this)
            ->filterByStatus(Cart::STATUS_PROCESSED, Criteria::BINARY_AND)
            ->filterByDate($dates)
            ->withColumn('SUM(cart.amount_excl)', 'sumAmountExcl')
            ->findOne();

        return $cart->getSumAmountExcl();
    }
}
