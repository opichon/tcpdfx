<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseItem;

class Item extends BaseItem
{
    public function getOrder()
    {
        return $this->getCart();
    }

    public function addQuantity($quantity)
    {
        $this->setQuantity($this->getQuantity() + $quantity);
    }

    public function setPrice($price)
    {
        if ($this->getTaxIncluded()) {
            $this->setPriceIncl($price);
        } else {
            $this->setPriceExcl($price);
        }

        $this->updateAmount();
    }

    public function updateAmount()
    {
        // TODO
    }
}
