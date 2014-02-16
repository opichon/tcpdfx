<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BasePayment;

class Payment extends BasePayment
{
    const STATUS_OPEN      = 0;
    const STATUS_CANCELLED = 2;
    const STATUS_ERROR     = 4;
    const STATUS_APPROVED  = 8;
    const STATUS_PAID      = 16;
}
