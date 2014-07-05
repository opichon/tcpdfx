<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\ItemQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\SalesFilterType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/sale")
 */
class SaleController extends BaseController
{
    /**
     * @Route("/", name="sales")
     * @Template("DzangocartCoreBundle:Sale:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new SalesFilterType());

        return array_merge(
            $this->getTemplateParams(),
            array(
                'store' => $this->getStore(),
                'template' => $this->getBaseTemplate(),
                'form' => $form->createView()
            )
        );

    }

    /**
     * @Route("/list", name="sales_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Sale:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        if ($affiliate_id = $request->query->get('affiliate_id')) {
            $query
                ->useCartQuery()
                    ->filterByAffiliateId($affiliate_id)
                ->endUse();
        }

        if ($customer_id = $request->query->get('customer_id')) {
            $query
                ->useCartQuery()
                    ->filterByCustomerId($customer_id)
                    ->filterByStatus(array('min' => 3))
                ->endUse();
        }

        if ($store_id = $request->query->get('store_id')) {
            $query
                ->useCartQuery()
                    ->filterByStoreId($store_id)
                    ->filterByStatus(array('min' => 3))
                ->endUse();
        }

        $total_count = $query->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $sales = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array_merge(
            $this->getTemplateParams(),
            array(
                'total_count' => $total_count,
                'filtered_count' => $filtered_count,
                'sales' => $sales
            )
        );
    }

    protected function getQuery()
    {
        return ItemQuery::create()
            ->innerJoinCart()
            ->filterByParentId(null);
    }

    protected function getTemplateParams()
    {
        return array();
    }

    protected function getLimit(Request $request)
    {
        return min(100, $request->query->get('length', 10));
    }

    protected function getOffset(Request $request)
    {
        return max($request->query->get('start', 0), 0);
    }

    protected function getFilters(Request $request)
    {
        return $request->query->get('sales_filters', array());
    }

    protected function getSearchColumns()
    {
        return array(
            'order_id' => 'item.orderId LIKE "%%%s%%"',
            'name' => 'item.name LIKE "%%%s%%"',
            'customer_id' => 'Cart.customerId = "%s%%"',
            'date_start' => 'Cart.date >= CONCAT("%s%%, 00:00:00")',
            'date_end' => 'Cart.date <= CONCAT("%s%%, 23:59:59")'
        );
    }

    /**
     * Returns the sort order parameters in a format that can be passed
     * as the argument to the ItemQuery#sort method.
     *
     * If the request query provides no sort order indications, this method
     * should return an array reflecting the default sort order (by date).
     *
     * @return array
     */
    protected function getSortOrder(Request $request)
    {
        $sort = array();

        $order = $request->query->get('order', array());

        $columns = $this->getSortColumns();

        foreach ($order as $setting) {

            $index = $setting['column'];

            if (array_key_exists($index, $columns)) {
                $sort[] = array(
                    $columns[$index],
                    $setting['dir']
                );
            }
        }

       if (empty($sort)) {
            $sort[] = array(
                'Cart.date',
                'asc'
            );
        }

        return $sort;
    }

    protected function getSortColumns()
    {
        return array(
            1 => 'Cart.Date',
            2 => 'item.orderId',
            3 => 'store.Name',
            5 => 'item.name',
            6 => 'item.quantity',
            7 => 'item.currencyId',
            8 => 'item.amount_excl',
            9 => 'item.tax_amount',
            10 => 'item.amount_incl'
        );
    }
}
