<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use \Criteria;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseStoreQuery;

class StoreQuery extends BaseStoreQuery
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
        return $this->orderBy('store.domain');
    }
}
