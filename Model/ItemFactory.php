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
        $item = $this->getCurrentItem($cart, $name, $code, $price, $options);

        $adjusted_quantity = $this->getAllowedQuantity($cart,$quantity, $code);

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

        //$item->save();

        $cart->reload(true);

        //$cart->updateAmounts();

        return $item;
    }

    public function getAllowedQuantity($cart, $quantity, $code)
    {
        if (!$cart || !$quantity) {
            return 0;
        }

        $max_quantity = $this->category->getMaxQuantity();

        // no limit
        if ($max_quantity == 0) {
            return $quantity;
        }

        $max_per_code = $this->category->getMaxPerCode();

        //FIX ME: create the logic to get $current_quantity;
        $current_quantity = 0;

//        $current_quantity = $cart->getCustomer()
//            ? $cart->getCustomer()->getQuantity() + $cart->getQuantity()
//            : $cart->getQuantity();

        if ($current_quantity >= $max_quantity) {
            return 0;
        }

        return min($quantity, $max_quantity - $current_quantity);
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
