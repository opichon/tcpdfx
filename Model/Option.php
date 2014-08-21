<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

class Option
{

    /**
     * 
     * @return options after parsing
     */
    public static function parse_options($options)
    {
        return $options;
    }

    /**
     * 
     * @return adjusted code
     */
    public static function getAdjustedCode($code = null, $option = null)
    {
        return $code;
    }

    /**
     * 
     * @return adjusted value
     */
    public static function getAdjustedValue($value, $option = null)
    {
        return $value;
    }
}
