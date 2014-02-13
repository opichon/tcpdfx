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
        return $this->orderBy('payment.orderId');
    }
}
