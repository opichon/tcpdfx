<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCategory;

class Category extends BaseCategory
{
    protected $item_factory;

    public function getPcode()
    {
        return $this->pcode;
    }

    public function setPcode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pcode !== $v) {
            $this->pcode = $v;
            $this->modifiedColumns[] = CategoryPeer::PCODE;
        }

        return $this;
    }

    public function isPackOnly()
    {
        return $this->getPackOnly();
    }

    public function isNotForSale()
    {
        return $this->getNotForSale();
    }

    public function addItemToCart($cart, $name, $price, $quantity, $code, $options)
    {
        //TODO
    }

    public function getItemFactory()
    {
        if (!$this->item_factory) {
            //FIXME: [JP 15-08-2014] need to consider pack item.
            $cls = $this->getItemFactoryClass() ? $this->getItemFactoryClass() : 'ItemFactory';
            $this->item_factory = new $cls($this);
        }

        return $this->item_factory;
    }
}
