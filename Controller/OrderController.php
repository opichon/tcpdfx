<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\CartQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrdersFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/order")
 */
class OrderController extends BaseController
{
    /**
    * @Route("/", name="orders")
    * @Template("DzangocartCoreBundle:Order:index.html.twig")
    */
    public function indexAction(Request $request)
    {
        $filters = $this->createForm(
            new OrdersFiltersType(),
            array(
                'date_from' => (new DateTime())->modify('first day of this month'),
                'date_to' => new DateTime()
            )
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'filters' => $filters->createView(),
                'template' => $this->getBaseTemplate()
            )
        );
    }

    /**
     * @Route("/list", name="orders_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Order:list.json.twig")
     */
    public function listAction(Request $request)
    {

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

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $orders = $query
//            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array_merge(
            $this->getTemplateParams(),
            array(
                'total_count' => $total_count,
                'filtered_count' => $filtered_count,
                'orders' => $orders
            )
        );
    }

    /**
     * @Route("/{id}", name="order", requirements={"id": "\d+"})
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
            ->processed()
            ->innerJoinStore();
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
        return max(0, $request->query->get('start', 0));
    }

    protected function getFilters(Request $request)
    {
        return $request->query->get('orders_filters', array());
    }

    protected function getSearchColumns()
    {
        return array(
            'id' => 'cart.id = %d',
            'store' => 'cart.storeId = %d',
            'customer_id' => 'cart.customerId = %d',
            'date_from' => 'cart.date >= "%s 00:00:00"',
            'date_to' => 'cart.date <= "%s 23:59:59"'
        );
    }

    protected function getSortOrder(Request $request)
    {
        $sort_order = array();

        $order = $request->query->get('order', array());

        $columns = $this->getDatatablesSortColumns();
        $i = 0;
        foreach ($order as $setting) {

            $index = $setting['column'];

            if (!array_key_exists($index, $columns)) {
                $sort_order[$i]['column'] = $columns[1] ;
                $sort_order[$i]['dir'] = 'asc';

                return $sort_order;
            }

            $sort_order[$i]['column'] = $columns[$index] ;
            $sort_order[$i]['dir'] = $setting['dir'];
            $i++;

        }

        return $sort_order;
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
}
