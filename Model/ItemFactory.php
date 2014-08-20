<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\Category;

class ItemFactory
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function addItemToCart(Cart $cart, $name, $price, $quantity, $code, $options = array())
    {

        $adjusted_quantity = $this->getAllowedQuantity($cart, $quantity, $code, $options);

        if ($adjusted_quantity == 0) {
            return;
        }

        // if item exist, no need to add to cart but modified existing item.
        $item = $this->getCurrentItem($cart, $name, $code, $price, $options);

        if ($adjusted_quantity > 0) {
            $this->increaseQuantity($item, $adjusted_quantity);
        } else {
            $this->updateItemPrice($item, $price, $options);
        }

        if (!$item) {
            $item = $this->addNewItem($cart, $name, $price, $adjusted_quantity, $code, $options);
        }

        //$item->save();

        $cart->reload(true);

        //$cart->updateAmounts();

        return $item;
    }

    public function getAllowedQuantity(Cart $cart, $quantity, $code, $options = array())
    {
        if (!$quantity) {
            return 0;
        }

        $max_quantity = $this->category->getMaxQuantity();

        // no limit
        if ($max_quantity == 0) {
            return $quantity;
        }

        $max_per_code = $this->category->getMaxPerCode();

        if ($cart->getCustomer()) {
            $current_quantity = $cart->getCustomer()->getQuantity($this->category, $max_per_code ? $code : null) + $cart->getQuantity($this->category, $max_per_code ? $code : null);

        } else {
            $current_quantity = $cart->getQuantity($this->category, $max_per_code ? $code : null);
        }

        if ($current_quantity >= $max_quantity) {
            return 0;
        }

        return min($quantity, $max_quantity - $current_quantity);
    }

    protected function getCurrentItem(Cart $cart, $name, $code, $price, $options = array())
    {
        //TODO
    }

    public function increaseQuantity($item, $adjusted_quantity)
    {
        //TODO
    }

    protected function addNewItem(Cart $cart, $name, $price, $adjusted_quantity, $code, $options)
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
