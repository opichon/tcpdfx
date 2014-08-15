<?php


class ItemFactory
{
    public function addItemToCart($cart, $name, $price, $quantity, $code, $options)
    {
        //TODO
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
}
