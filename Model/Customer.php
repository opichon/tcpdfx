<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCustomer;

class Customer extends BaseCustomer
{
    public function getProfile()
    {
        return $this->getUserProfile();
    }

    public function getUser()
    {
        return $this
            ->getProfile()
            ->getUser();
    }

    public function getName()
    {
        return $this
            ->getProfile()
            ->getFullName(true);
    }

    //returns the sum of quantity of item for cart
    public function getQuantity(Category $category, $name = null, $code = null)
    {
        return 0;
    }
}
