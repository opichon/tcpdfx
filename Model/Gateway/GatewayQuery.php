<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Gateway;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\om\BaseGatewayQuery;

class GatewayQuery extends BaseGatewayQuery
{
     public function filter(array $search = null, array $columns = array())
    {
        if (empty($search)) {
            return $this;
        }

        $conditions = array();

        foreach ($columns as $i => $column) {
            $value = trim($search[$i]);

            if (!is_array($column)) {
                $this->condition(
                    'search_' . $i,
                    sprintf($column, $value)
                );

                $conditions [] = 'search_' . $i;
            } else {
                $or_conditions = array();

                foreach ($column as $or_column) {
                    $this->condition(
                        'orsearch_' . $or_column,
                        sprintf($or_column, $value)
                    );
                    $or_conditions [] = 'orsearch_' . $or_column;
                }

                $this->where($or_conditions, 'or');
            }

        }

        return $this->where($conditions, 'and');
    }

    public function sort(array $order = array())
    {
        return $this;
    }
}
