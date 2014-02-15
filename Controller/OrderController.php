<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\CartQuery;
use Dzangocart\StoreAdminBundle\Form\Type\OrderFiltersType;

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

            $query = CartQuery::create('Cart')
                ->filterByStore($this->getStore())
                ->filterByStatus(array('min' => 3));

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
                'orders' => $orders
            );

            $view = $this->renderView('DzangocartCoreBundle:Order:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

        $form = $this->createForm(
            new OrderFiltersType());

        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );

    }

    /**
     * @Route("/order/{id}", name="order")
     * @Template("DzangocartCoreBundle:Order:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $order = CartQuery::create()
            ->filterByStore($this->getStore())
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
            1 => 'cart.id',
            2 => 'cart.storeId',
            3 => 'cart.date',
            4 => 'cart.status'
        );
    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'id' => 'cart.id LIKE "%%%s%%"',
            'store_name' => 'store.name LIKE "%%%s%%"',
        );
    }

    protected function getBaseTemplate()
    {
        return 'DzangocartCoreBundle::layout.html.twig';
    }
}
