<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Gateway;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\om\BaseGatewayQuery;

class GatewayQuery extends BaseGatewayQuery
{
    public function filter(array $filters = null, array $columns = array())
    {
        return $this;
    }

    public function sort(array $order = array())
    {
        return $this;
    }
}
