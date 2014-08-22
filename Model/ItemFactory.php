<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\Category;
use Dzangocart\Bundle\CoreBundle\Model\Option;

class ItemFactory
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function addItemToCart(Cart $cart, $name, $price, $quantity, $code, $options = array())
    {

        $adjusted_quantity = $this->getAllowedQuantity($cart, Option::getAdjustedValue($quantity, @$options['q']), $code, $options);

        if ($adjusted_quantity == 0) {
            return;
        }

        // if item exist, no need to add to cart but modified existing item.
        $item = $this->getCurrentItem($cart, $name, $code, $price, $options);

        if (!$item) {
            $item = $this->addNewItem($cart, $name, $price, $adjusted_quantity, $code, $options);
        } else {

            if ($adjusted_quantity > 0) {
                $this->increaseQuantity($item, $adjusted_quantity);
            }

            $this->updateItemPrice($item, $price, @$options['p']);
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

        $current_quantity = $cart->getQuantity(
            $this->category,
            $max_per_code ? $code : null
        );

        if ($cart->getCustomer()) {
            $current_quantity +=
                $cart->getCustomer()->getQuantity(
                    $this->category,
                    $max_per_code ? $code : null
                );
        }

        return min($quantity, max(0, $max_quantity - $current_quantity));
    }

    protected function getCurrentItem(Cart $cart, $name, $code, $price, $options = array())
    {
        return $cart->getItem(
            $this->category,
            Option::getAdjustedCode($name, @$options['n']),
            Option::getAdjustedCode($code, @$options['c']),
            $price
        );
    }

    public function increaseQuantity($item, $adjusted_quantity)
    {
        $item->addQuantity($adjusted_quantity);
    }

    protected function addNewItem(Cart $cart, $name, $price, $adjusted_quantity, $code, $options)
    {
        //TODO
    }

    protected function updateItemPrice($item, $price, $option = null)
    {
        $this->setItemPrice($item, $price, $option);
    }

    public function createItem($name, $price, $quantity, $code, $options = array())
    {
        //TODO
    }

    public function setItemName($item, $name, $option = null)
    {
        $item->setName(Option::getAdjustedCode($name, $option));
    }

    public function setItemCode($item, $code, $option = null)
    {
        $item->setCode(Option::getAdjustedCode($code, $option));
    }

    public function setItemQuantity($item, $quantity, $option = null)
    {
        $item->setQuantity(Option::getAdjustedValue($quantity, $option));
    }

    public function setItemPrice($item, $price, $option = null)
    {
        $item->setPrice(Option::getAdjustedValue($price, $option));
    }
}
