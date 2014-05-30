<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use \Criteria;

use Dzangocart\Bundle\CoreBundle\Model\om\BasePaymentQuery;

use Symfony\Component\HttpFoundation\ParameterBag;

class PaymentQuery extends BasePaymentQuery
{
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

    protected function defaultSort()
    {
        return $this->orderBy('payment.orderId');
    }
}
