<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\Promotion\om\BasePromotionQuery;

use Symfony\Component\HttpFoundation\ParameterBag;

class PromotionQuery extends BasePromotionQuery
{
    /**
     * @deprecated
     */
    public function dataTablesSort(ParameterBag $params, array $columns = array())
    {
        $control = 0;
        for ($i = 0; $i < $params->get('iSortingCols'); $i++) {
            $index = $params->get('iSortCol_' . $i);
            if (array_key_exists($index, $columns)) {
                $sort_columns = $columns[$index];
                $dir = 'desc' == strtolower($params->get('sSortDir_' . $i)) ? Criteria::DESC : Criteria::ASC;
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

    public function dataTablesSearch($search, array $columns = array())
    {
        $search = trim($search);

        if (empty($search)) { return $this; }

        $conditions = array();

        foreach ($columns as $i => $column) {
            $this->condition(
                'search_' . $i,
                sprintf('%s LIKE ?', $column),
                sprintf('%%%s%%', $search)
            );

            $conditions [] = 'search_' . $i;
        }

        return $this->where($conditions, 'or');
    }

    protected function defaultSort()
    {
        return $this->orderBy('promotion.id');
    }

    public function sort(array $order = array())
    {
        foreach ($order as $setting) {
            $column = $setting[0];
            $direction = $setting[1];
            $this->orderBy($column, $direction);
        }

        return $this;
    }

    public function filter($filters = null, array $columns = array())
    {
        if (empty($filters)) {
            return $this;
        }

        $conditions = array();

        if (is_array($filters)) {

            foreach ($columns as $name => $condition) {

                if (!array_key_exists($name, $filters)) {
                    continue;
                }

                $value = trim($filters[$name]);

                if (empty($value) && !is_numeric($value)) {
                    continue;
                }

                if (is_array($condition)) {

                    $sub_conditions = array();

                    foreach ($condition as $i => $sub_condition) {
                        $sub_name = sprintf('search_%s_%d', $name, $i);

                        $this->condition(
                            $sub_name,
                            sprintf($sub_condition, $value)
                        );

                        $sub_conditions[] = $sub_name;
                    }

                    if (!empty($sub_conditions)) {
                        $this->combine($sub_conditions, 'or', 'search_' . $name);
                    }

                } else {

                    $this->condition(
                        'search_' . $name,
                        sprintf($condition, $value)
                    );

                }

                $conditions[] = 'search_' . $name;
            }

        if (!empty($conditions)) {
            return $this->where($conditions, 'and');
        }

        } else {
            $value = trim($filters);

            foreach ($columns as $name => $condition) {
                $this->condition(
                    'search_' . $name,
                    sprintf($condition, $value)
                );

                $conditions[] = 'search_' . $name;
            }

            return $this->where($conditions, 'or');
        }
    }
    
}
