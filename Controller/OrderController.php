<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\CartQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends BaseController
{
    /**
    * @Route("/order", name="orders")
    * @Template("DzangocartCoreBundle:Order:index.html.twig")
    */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {
            $query = $this->getQuery();

            if ($customer_id = $request->query->get('customer_id')) {
                $query->filterByCustomerId($customer_id);
            }

            if ($affiliate_id = $request->query->get('affiliate_id')) {
                $query->filterByAffiliateId($affiliate_id);
            }

            if ($store_id = $request->query->get('store_id')) {
                $query->filterByStoreId($store_id);
            }

            $total_count = $query->count();

            $query->datatablesSearch(
                $request->query->get('order_filters'),
                $this->getDataTablesSearchColumns()
            );

            $query->innerJoinStore('store');

            $filtered_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));

            $orders = $query
                ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'orders' => $orders,
                'param' => $this->getTemplateParams()
            );

            $view = $this->renderView('DzangocartCoreBundle:Order:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

        $form = $this->createForm(
            new OrderFiltersType());

        return array_merge(
            $this->getTemplateParams(),
            array(
                'form' => $form->createView(),
                'template' => $this->getBaseTemplate()
            )
        );
    }

    /**
     * @Route("/order/{id}", name="order")
     * @Template("DzangocartCoreBundle:Order:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $order = $this->getQuery()
            ->orderByDate(Criteria::ASC)
            ->findPk($id);

        if (!$order) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('order.show.error.not_found', array(), 'order', $request->getLocale())
            );
        }

        return array(
            'order' => $order,
            'template' => $this->getBaseTemplate(),
            'store' => $order->getStore(),
        );
    }

    protected function getQuery()
    {
        return CartQuery::create()
            ->filterByStatus(array('min' => 3));
    }

    protected function getTemplateParams()
    {
        return array();
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'cart.date',
            2 => 'cart.id',
            3 => 'store.Name',
            5 => 'cart.status',
            6 => 'cart.currency',
            7 => 'cart.amount_excl',
            8 => 'cart.tax_amount',
            9 => 'cart.amount_incl'
        );
    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'id' => 'cart.id LIKE "%s%%"',
            'store_name' => 'store.name LIKE "%%%s%%"',
        );
    }
}
