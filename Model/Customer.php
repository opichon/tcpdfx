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

    /**
     * @return the sum of quantity of item for customer
     */
    public function getQuantity(Category $category, $code = null)
    {
        return 0;
    }
}
