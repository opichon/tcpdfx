<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCustomerQuery;

class CustomerQuery extends BaseCustomerQuery
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

    /**
     * Adds sorting to the query. The sort order is provided by the $order argument
     * in the form of a 2-dimensional array. Each array element is an array in the form of
     * [field, direction], where:
     * - field is a column-name in a format understandable by this Propel query
     * - direction is either Criteria::ASC or Criteria::DESC
     *
     * @param $order Array a 2-dimensional array in the form of [[field1, direction1],[field2, direction2],...]
     *
     * @Return CustomerQuery this query
     */
    public function sort(array $order = array())
    {
        foreach ($order as $setting) {
            $column = $setting[0];
            $direction = $setting[1];
            $this->orderBy($column, $direction);
        }

        return $this;
    }
}
