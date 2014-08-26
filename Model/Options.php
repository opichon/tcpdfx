<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

class Options
{
    protected $options;

    public function __construct($options = array())
    {
        $this->options = $options;
    }

    /**
     * 
     * @return adjusted code
     */
    public function getAdjustedCode($code = null)
    {
        return $code;
    }

    /**
     * 
     * @return adjusted value
     */
    public function getAdjustedValue($value)
    {
        return $value;
    }
}
