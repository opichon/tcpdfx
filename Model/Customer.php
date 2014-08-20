<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Criteria;

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
        $query = ItemQuery::create()
            ->useCartQuery()
                ->filterByCustomer($this)
            ->endUse()
            ->filterByCategory($category)
            ->filterByDeletedAt(null, Criteria::ISNULL);

        if ($code) {
            $query->filterByCode($code, Criteria::LIKE);
        }

        $item = $query->withColumn('SUM(item.quantity)', 'customerQuantity')
            ->findOne();

        return $item->getCustomerQuantity() ? $item->getCustomerQuantity() : 0;
    }
}
