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

        $query->datatablesSearch(
            $request->query->get('sales_filters', array()),
            $this->getDataTablesSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $sales = $query
            ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'draw' => $request->query->get('draw'),
            'start' => 0,
            'recordsTotal' => $total_count,
            'recordsFiltered' => $filtered_count,
            'sales' => $sales,
            'param' => $this->getTemplateParams()
        );
    }

    protected function getDatatablesSortColumns()
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

    protected function getDataTablesSearchColumns()
    {
        return array(
            'order_id' => 'item.orderId LIKE "%%%s%%"',
            'name' => 'item.name LIKE "%%%s%%"',
            'customer_id' => 'Cart.customerId = "%s%%"',
            'date_start' => 'Cart.date >= CONCAT("%s%%, 00:00:00")',
            'date_end' => 'Cart.date <= CONCAT("%s%%, 23:59:59")'
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
        return $request->query->get('length', 10);
    }

    protected function getOffset(Request $request)
    {
        return $request->query->get('start', 0);
    }
}
