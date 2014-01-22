<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\CategoryPeer;
use Dzangocart\Bundle\CoreBundle\Model\om\BaseStore;

class Store extends BaseStore
{
    public function fixCatalogue($scope_id)
    {
        CategoryPeer::fixLevels($scope_id);
    }
}
