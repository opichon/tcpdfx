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

            $query = ItemQuery::create()
                ->filterByParentId(null);

            if ($store = $this->getStore()) {
                $query
                    ->useCartQuery()
                        ->filterByStore($store)
                        ->filterByStatus(array('min' => 3))
                    ->endUse();
            } elseif ($store_id = $request->query->get('store_id')) {
                $query
                    ->useCartQuery()
                        ->filterByStoreId($store_id)
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
                'sales' => $sales
            );

            $view = $this->renderView('DzangocartCoreBundle:Sale:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

        return array(
            'store' => $this->getStore(),
            'template' => $this->getBaseTemplate()
        );
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'Cart.Date',
            2 => 'item.orderId',
            3 => 'store.Name',
            4 => 'item.name',
            5 => 'item.code',
            6 => 'item.currencyId',
            7 => 'item.quantity'
        );

    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'item.orderId'
        );
    }
}
