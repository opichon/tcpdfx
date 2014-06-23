<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\CartQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends BaseController
{
    /**
    * @Route("/cart", name="carts")
    * @Template("DzangocartCoreBundle:Cart:index.html.twig")
    */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(
            new OrderFiltersType());

        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/cart//list", name="cart_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Order:list.json.twig")
     */
    public function listAction(Request $request)
    {

        $query = $this->getQuery();

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

        $limit = min(100, $request->query->get('length'));
        $offset = max(0, $request->query->get('start'));

        $orders = $query
            ->dataTablesSort($request->query->get('order', array()), $this->getDataTablesSortColumns())
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'draw' => $request->query->get('draw'),
            'start' => 0,
            'count_total' => $total_count,
            'count_filtered' => $filtered_count,
            'orders' => $orders
        );
    }
    /**
     * @Route("/cart/{id}", name="cart")
     * @Template("DzangocartCoreBundle:Cart:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $order = CartQuery::create()
            ->findPk($id);

        if (!$order) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('order.show.error.not_found', array(), 'order', $request->getLocale())
            );
        }

        return array(
            'store' => $this->getStore(),
            'order' => $order,
        );
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'cart.date',
            2 => 'cart.id',
            3 => 'store.Name',
            4 => 'cart.status'
        );
    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'id' => 'cart.id LIKE "%s%%"',
            'store_name' => 'store.name LIKE "%%%s%%"',
            'customer_id' => 'cart.customer_id = "%s%%"',
            'date_start' => 'cart.date BETWEEN CONCAT("%s%%, 00:00:00")',
            'date_end' => 'CONCAT("%s%%, 23:59:59")'
        );
    }

    protected function getQuery()
    {
        return CartQuery::create('Cart')
            ->filterByStatus(Cart::STATUS_OPEN);
    }
}
