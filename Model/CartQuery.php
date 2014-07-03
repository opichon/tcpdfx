<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use \Criteria;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCartQuery;

class CartQuery extends BaseCartQuery
{
    public function datatablesSort(array $order = array(), array $columns = array())
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

    protected function defaultSort()
    {
        return $this->orderBy('cart.id');
    }

    public function dataTablesSearch(array $filters = null, array $columns = array())
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

    public function apiSearch(array $filters = null, array $columns = array())
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
