<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCartQuery;

class CartQuery extends BaseCartQuery
{
    public function sort(array $order = array())
    {
        foreach ($order as $setting) {
            $sort_columns = $setting['column'];
            $dir = $setting['dir'];
            $this->orderBy($sort_columns, $dir);
        }

        return $this;
    }

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
}
