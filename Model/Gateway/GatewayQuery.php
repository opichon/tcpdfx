<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Gateway;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\om\BaseGatewayQuery;

class GatewayQuery extends BaseGatewayQuery
{
    public function filter(array $filters = null, array $columns = array())
    {
        if (empty($filters)) {
            return $this;
        }

        $conditions = array();

        foreach ($columns as $name => $condition) {
            if (!array_key_exists($name, $filters)) {
                continue;
            }

            $value = trim($filters[$name]);

            if (empty($value) && !is_numeric($value)) {
                continue;
            }

            $this->condition(
                'search_' . $name,
                sprintf($condition, $value)
            );

            $conditions[] = 'search_' . $name;
        }

        if (!empty($conditions)) {
            return $this->where($conditions, 'and');
        }
    }

    public function sort(array $order = array())
    {
        return $this;
    }
}
