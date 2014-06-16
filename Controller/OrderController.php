<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\CartQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $count_total = $query->count();

        $query->datatablesSearch(
            $request->query->get('order_filters'),
            $this->getDataTablesSearchColumns()
        );

        $count_filtered = $query->count();

        $limit = min(100, $request->query->get('length', 10));
        $offset = max(0, $request->query->get('start', 0));

        $orders = $query
            ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'draw' => $request->query->get('draw'),
            'count_total' => $count_total,
            'count_filtered' => $count_filtered,
            'orders' => $orders,
            'param' => $this->getTemplateParams()
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
            ->filterByStatus(Cart::STATUS_PROCESSED, Criteria::BINARY_AND)
            ->innerJoinStore('store');
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
            'customer_id' => 'cart.customer_id = "%s%%"',
            'date_start' => 'cart.date >= CONCAT("%s%%, 00:00:00")',
            'date_end' => 'cart.date <= CONCAT("%s%%, 23:59:59")'
        );
    }
}
