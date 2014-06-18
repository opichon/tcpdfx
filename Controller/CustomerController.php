<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Criteria;

use Dzangocart\Bundle\CoreBundle\Model\CustomerQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\CustomerFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\PaymentFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\SalesFilterType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/customer")
 */
class CustomerController extends BaseController
{
    /**
     * @Route("/", name="customers")
     * @Template("DzangocartCoreBundle:Customer:index.html.twig")
     */

    public function indexAction(Request $request)
    {
        $form = $this->createForm(
              new CustomerFiltersType()
        );

        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/list", name="customers_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Customer:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

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

        $count_total = $query->count();

        $query->datatablesSearch(
            $request->query->get('customer_filters'),
            $this->getDataTablesSearchColumns()
        );

        $count_filtered = $query->count();

        $limit = min(100, $request->query->get('length', 10));
        $offset = max(0, $request->query->get('start', 0));

        $customers = $query
            ->dataTablesSort(
                $request->query->get('order', array()),
                $this->getDataTablesSortColumns()
            )
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'draw' => $request->query->get('draw'),
            'count_total' => $count_total,
            'count_filtered' => $count_filtered,
            'customers' => $customers
        );
    }

    /**
     * @Route("/{id}", name="customer_show", requirements={"id": "\d+"})
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
     * @Route("/{id}/edit", name="customer_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {

    }

     /**
     * @Route("/{id}/orders",name="customer_orders")
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
     * @Route("/{id}/payments", name="customer_payments")
     * @Template("DzangocartCoreBundle:Customer:payments.html.twig")
     */
    public function paymentsAction(Request $request, $id)
    {
        $form = $this->createForm(
            new PaymentFiltersType($this->getStore())
        );

        return array(
            'store' => $this->getStore(),
            'customer' => $this->getCustomer($request, $id),
            'template' => $this->getBaseTemplate(),
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/purchases", name="customer_purchases")
     * @Template("DzangocartCoreBundle:Customer:purchases.html.twig")
     */
    public function purchasesAction(Request $request, $id)
    {
        $form = $this->createForm(
            new SalesFilterType()
        );

        return array(
            'store' => $this->getStore(),
            'customer' => $this->getCustomer($request, $id),
            'template' => $this->getBaseTemplate(),
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/search/{search}", name="customer_search", defaults={ "_format": "json" })
     * @Template("DzangocartCoreBundle:Order:search.json.twig")
     */
    public function searchAction(Request $request, $search = '%QUERY')
    {
        $customers = CustomerQuery::create()
            ->useUserProfileQuery()
                ->filterByGivenNames(sprintf('%%%s%%', $search), Criteria::LIKE)
                ->_or()
                ->filterBySurname(sprintf('%%%s%%', $search), Criteria::LIKE)
                ->_or()
                ->where('CONCAT(user_profile.surname, ", ", user_profile.given_names) LIKE ?', sprintf('%%%s%%', $search))
                ->_or()
                ->where('CONCAT(user_profile.surname, " ", user_profile.given_names) LIKE ?', sprintf('%%%s%%', $search))
                ->_or()
                ->where('CONCAT(user_profile.given_names, ", ", user_profile.surname) LIKE ?', sprintf('%%%s%%', $search))
                ->_or()
                ->where('CONCAT(user_profile.given_names, ", ", user_profile.surname) LIKE ?', sprintf('%%%s%%', $search))
            ->endUse()
            ->distinct()
            ->find();

        return array(
            'customers' => $customers
        );
    }

    protected function getQuery()
    {
        return CustomerQuery::create()
            ->innerJoinUserProfile('user_profile')
            ->innerJoinCart('cart')
            ->withColumn('SUM(cart.amount_excl)', 'sales')
            ->groupBy('customer.id');
    }

    protected function getDataTablesSortColumns()
    {
        return array(
            1 => 'customer.realm',
            2 => 'user_profile.Surname',
            3 => 'user_profile.GivenNames'

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
