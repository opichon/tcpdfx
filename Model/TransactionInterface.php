<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

interface TransactionInterface
{

    /**
     * Returns the transaction id
     *
     * @return integer
     */
    public function getId();

    /**
     * Returns the transaction amount
     *
     * @return float
     */
    public function getAmount();

    /**
     * @return Payment
     */
    public function getPayment();

    /**
     * Return the currency used for the transaction
     *
     *@return string
     */
    public function getCurrency();
}
