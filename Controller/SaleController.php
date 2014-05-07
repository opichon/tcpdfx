<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\ItemQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SaleController extends BaseController
{
    /**
     * @Route("/sales", name="sales")
     * @Template("DzangocartCoreBundle:Sale:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = $this->getQuery();

            if ($affiliate_id = $request->query->get('affiliate_id')) {
                $query
                    ->useCartQuery()
                        ->filterByAffiliateId($affiliate_id)
                    ->endUse();
            }

            if ($store_id = $request->query->get('store_id')) {
                $query
                    ->useCartQuery()
                        ->filterByStoreId($store_id)
                        ->filterByStatus(array('min' => 3))
                    ->endUse();
            }

            if ($customer_id = $request->query->get('customer_id')) {
                $query
                    ->useCartQuery()
                        ->filterByCustomerId($customer_id)
                        ->filterByStatus(array('min' => 3))
                    ->endUse();
            }

            $total_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));

            $query->datatablesSearch(
                $request->query->get('sSearch'),
                $this->getDataTablesSearchColumns()
            );

            $filtered_count = $query->count();

            $sales = $query
                ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'sales' => $sales,
                'param' => $this->getTemplateParams()
            );

            $view = $this->renderView('DzangocartCoreBundle:Sale:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

        return array_merge(
            $this->getTemplateParams(),
            array(
                'store' => $this->getStore(),
                'template' => $this->getBaseTemplate()
            )
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
            'item.orderId'
        );
    }

    protected function getQuery()
    {
        return ItemQuery::create()
            ->filterByParentId(null);
    }

    protected function getTemplateParams()
    {
        return array();
    }

}
