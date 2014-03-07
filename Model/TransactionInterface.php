<?php
 
namespace Dzangocart\Bundle\CoreBundle\Model;


interface TransactionInterface 
{
    
    /** 
     * return the transaction id
     * 
     *@return integer
     */
    public function getId();
 
    /**
     * return the amount of transaction
     * 
     * @return float
     */
    public function getAmount();
    
    /**
     * @return Payment
     */
    public function getPayment();

    /**
     * return the currency used for the transaction
     * 
     *@return string   
     */
    public function getCurrency();
    
}
