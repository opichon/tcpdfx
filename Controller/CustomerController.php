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

            $query = CustomerQuery::create()
                ->innerJoinUserProfile();

            if ($store = $this->getStore()) {
                $query
                    ->filterByRealm($store->getRealm());
            } elseif ($realm = $request->query->get('realm')) {
                $query
                    ->filterByRealm($realm);
            }

            if ($affiliate_id = $request->query->get('affiliate_id')) {
                $query->filterByAffiliateId($affiliate_id);
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
        $customer = $this->getCustomer($request, $id);

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
        $form = $this->createForm(
            new OrderFiltersType());

        return array(
            'store' => $this->getStore(),
            'customer' => $this->getCustomer($request, $id),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()

        );
    }

     /**
     * @Route("/customer/{id}/payments", name="customer_payments")
     * @Template("DzangocartCoreBundle:Customer:payments.html.twig")
     */
    public function paymentsAction(Request $request, $id)
    {
        return array(
            'store' => $this->getStore(),
            'customer' => $this->getCustomer($request, $id),
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/customer/{id}/purchases", name="customer_purchases")
     * @Template("DzangocartCoreBundle:Customer:purchases.html.twig")
     */
    public function purchasesAction(Request $request, $id)
    {
        return array(
            'store' => $this->getStore(),
            'customer' => $this->getCustomer($request, $id),
            'template' => $this->getBaseTemplate()
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
            'surname' => 'user_profile.surname LIKE "%%%s%%"',
            'given_names' => 'user_profile.given_names LIKE "%%%s%%"',
            'email' => 'user_profile.email LIKE "%%%s%%"',
            'gender' => 'user_profile.gender LIKE "%s"',
        );
    }

    protected function getCustomer(Request $request, $id)
    {
        $customer = CustomerQuery::create()
            ->findPk($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('customer.error.notfound', array(), 'customer', $request->getLocale())
            );
        }

        return $customer;
    }
}
