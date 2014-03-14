<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\CustomerQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\CustomerFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends BaseController
{
    /**
     * @Route("/customer", name="customers")
     * @Template("DzangocartCoreBundle:Customer:index.html.twig")
     */

    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = CustomerQuery::create();

            if ($store = $this->getStore()) {
                $query
                    ->filterByRealm($store->getRealm());
            } elseif ($realm = $request->query->get('realm')) {
                $query
                    ->filterByRealm($realm);
            }

            $total_count = $query->count();

            $query->datatablesSearch(
                $request->query->get('customer_filters'),
                $this->getDataTablesSearchColumns()
            );

            $filtered_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));

            $query->innerJoinCart('cart');

            $customers = $query
                ->withColumn('SUM(cart.amount_excl)', 'sales')
                ->groupBy('customer.id')
                ->datatablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'customers' => $customers
            );

            $view = $this->renderView('DzangocartCoreBundle:Customer:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }
            $form = $this->createForm(
                new CustomerFiltersType());

            return array(
                'store' => $this->getStore(),
                'form' => $form->createView(),
                'template' => $this->getBaseTemplate()
                    
         );
    }

    /**
     * @Route("/customer/{id}", name="customer_show")
     * @Template("DzangocartCoreBundle:Customer:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $customer = CustomerQuery::create()
            ->findPk($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('customer.show.error.not_found', array(), 'customer', $request->getLocale())
            );
        }

        return array(
            'store' => $this->getStore(),
            'customer' => $customer,
            'template' => $this->getBaseTemplate()
        );
    }

     /**
     * @Route("/customer/{id}", name="customer_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {

    }

     /**
     * @Route("/customer/{id}/orders",name="customer_orders")
     * @Template("DzangocartCoreBundle:Customer:orders.html.twig")
     */
    public function ordersAction(Request $request, $id)
    {
         $customer = CustomerQuery::create()
            ->findPk($id);
        
        $orders = \Dzangocart\Bundle\CoreBundle\Model\CartQuery::create()
            ->filterByStatus(array('min' => 3))
            ->filterByCustomerId($customer);
         
        $store = $this->getStore($id);

        $form = $this->createForm(
            new OrderFiltersType());

        return array(
            'store' => $store,
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate(),
            'customer' => $customer
       
        );
    }

    protected function getDataTablesSortColumns()
    {
        return array(
            1 => 'customer.realm',
            2 => 'customer.code',

        );
    }
    protected function getDataTablesSearchColumns()
    {
        return array(
            'realm' => 'customer.realm LIKE "%%%s%%"',
        );
    }
}
