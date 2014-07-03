<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseItemQuery;

use Symfony\Component\HttpFoundation\ParameterBag;

class ItemQuery extends BaseItemQuery
{
    public function dataTablesSort(ParameterBag $params, array $columns = array())
    {
        $control = 0;

        for ($i = 0; $i < $params->get('iSortingCols'); $i++) {

            $index = $params->get('iSortCol_' . $i);

            if (array_key_exists($index, $columns)) {

                $sort_columns = $columns[$index];

                $dir = 'desc' == strtolower($params->get('sSortDir_' . $i))
                    ? Criteria::DESC
                    : Criteria::ASC;

                if (!is_array($sort_columns)) {
                    $sort_columns = array($sort_columns);
                }

                foreach ($sort_columns as $column) {
                    $this->orderBy($column, $dir);
                }

                $control++;
            }
        }

        return $control ? $this : $this->defaultSort();
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

    public function apiSort(array $order = array(), array $columns = array())
    {
        $control = 0;

        foreach ($order as $setting) {

            $index = $setting['column'];

            if (array_key_exists($index, $columns)) {
                $sort_columns = $columns[$index];

                $dir = $setting['dir'] == 'asc'
                    ? Criteria::ASC
                    : Criteria::DESC;

                if (!is_array($sort_columns)) {
                    $sort_columns = array($sort_columns);
                }

                foreach ($sort_columns as $column) {
                    $this->orderBy($column, $dir);
                }

                $control++;
            }
        }

        return $control ? $this : $this->defaultSort();
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
     * @Return ItemQuery this query
     */
    public function sort($order = array())
    {
        return $this;
    }

    protected function defaultSort()
    {
        return $this->orderBy('item.orderId');
    }
}
