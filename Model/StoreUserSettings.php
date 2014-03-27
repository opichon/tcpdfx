<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseStoreUserSettings;

class StoreUserSettings extends BaseStoreUserSettings
{
    const USER_HANDLING_NONE        = 0;
    const USER_HANDLING_VIA_STORE   = 1;
    const USER_HANDLING_VIA_SITE    = 2;
}
