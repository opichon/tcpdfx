<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\Category;
use Dzangocart\Bundle\CoreBundle\Model\Options;

class ItemFactory
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function addItemToCart(Cart $cart, $name, $price, $quantity, $code, Options $options)
    {

        $adjusted_quantity = $this->getAllowedQuantity($cart, $options->getAdjustedValue($quantity), $code, $options);

        if ($adjusted_quantity == 0) {
            return;
        }

        // if item exist, no need to add to cart but modified existing item.
        $item = $this->getCurrentItem($cart, $name, $code, $price, $options);

        if (!$item) {
            $item = $this->addNewItem($cart, $name, $price, $adjusted_quantity, $code, $options);
        } else {

            $this->increaseQuantity($item, $adjusted_quantity);

            $this->updateItemPrice($item, $price, $options);
        }

        $cart->reload(true);

        $cart->updateAmounts();

        return $item;
    }

    public function getAllowedQuantity(Cart $cart, $quantity, $code, Options $options)
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

    protected function getCurrentItem(Cart $cart, $name, $code, $price, Options $options)
    {
        return $cart->getItem(
            $this->category,
            $options->getAdjustedValue($name),
            $options->getAdjustedCode($code),
            $price
        );
    }

    public function increaseQuantity($item, $adjusted_quantity)
    {
        $item->addQuantity($adjusted_quantity);
    }

    protected function addNewItem(Cart $cart, $name, $price, $adjusted_quantity, $code, Options $options)
    {
        $item = $this->createItem($name, $price, $adjusted_quantity, $code, $options);

        $item->setCart($cart);

        return $item;
    }

    protected function updateItemPrice($item, $price, Options $options)
    {
        $this->setItemPrice($item, $price, $options);
    }

    public function createItem($name, $price, $quantity, $code, Options $options)
    {
        $item = new Item();

        $item->setCategory($this->category);

        $item->setExport($this->category->getExport());

        $this->setItemName($item, $name, $options);

        $this->setItemCode($item, $code, $options);

        $this->setItemPrice($item, $price, $options);

        $item->setQuantity($quantity);

        $item->setCurrencyId($this->category->getStore()->getCurrencyId());

        $item->setTaxRate($this->category->getTaxRate());

        //$item->setTaxIncluded(array_key_exists('tax_incl', $options) ? $options['tax_incl'] : $this->category->getTaxIncluded());

        return $item;
    }

    public function setItemName($item, $name, Options $options)
    {
        $item->setName($options->getAdjustedCode($name));
    }

    public function setItemCode($item, $code, Options $options)
    {
        $item->setCode($options->getAdjustedCode($code));
    }

    public function setItemQuantity($item, $quantity, Options $options)
    {
        $item->setQuantity($options->getAdjustedValue($quantity));
    }

    public function setItemPrice($item, $price, Options $options)
    {
        $item->setPrice($options->getAdjustedValue($price));
    }
}
