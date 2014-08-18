<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\Category;

class ItemFactory
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function addItemToCart($cart, $name, $price, $quantity, $code, $options)
    {
        if ($cart->isNew()) {
            $cart->save();
        }

        $item = $this->getCurrentItem($cart, $name, $code, $price, $options);

        $adjusted_quantity = $this->getAllowedQuantity($cart, $name, $quantity, $code, $options);

        if ($adjusted_quantity == 0) {
            return;
        }

        if ($adjusted_quantity > 0) {
            $this->increaseQuantity($item, $adjusted_quantity);
        } else {
            $this->updateItemPrice($item, $price, $options);
        }

        if (!$item) {
            $this->addNewItem($cart, $name, $price, $adjusted_quantity, $code, $options);
        }

        $item->save();

        $cart->reload(true);

        //$cart->updateAmounts();

        return $item;
    }

    public function getAllowedQuantity($cart, $name, $quantity, $code, $options)
    {
        //TODO
    }

    protected function getCurrentItem($cart, $name, $code, $price, $options = array())
    {
        //TODO
    }

    public function increaseQuantity($item, $adjusted_quantity)
    {
        //TODO
    }

    protected function addNewItem($cart, $name, $price, $adjusted_quantity, $code, $options)
    {
        //TODO
    }

    protected function updateItemPrice($item, $price, $option = null)
    {
       //TODO
    }

    public function createItem($name, $price, $quantity, $code, $options = array())
    {
        //TODO
    }

    public function setItemName($item, $name, $option = null)
    {
        //TODO
    }

    public function setItemCode($item, $code, $option = null)
    {
        //TODO
    }

    public function setItemQuantity($item, $quantity, $option = null)
    {
        //TODO
    }

    public function setItemPrice($item, $price, $option = null)
    {
        //TODO
    }
}
