<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCurrency;

class Currency extends BaseCurrency
{
    public function format($amount)
    {
        return number_format(
            $amount,
            $this->getDecimals(),
            '.',
            ''
        );
    }
}
