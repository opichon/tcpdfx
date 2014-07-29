<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Criteria;
use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\CustomersFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrdersFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\StorePaymentsFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\SalesFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\CustomerQuery;

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
        $filters = $this->createForm(
              new CustomersFiltersType()
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/list", name="customers_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Customer:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        $today = date('Y-m-d') . ' 23:59:59';

        $year_start = date('Y-01-01') . ' 00:00:00';

        $subquery = sprintf(
            "( SELECT SUM(cart.amount_excl) FROM cart WHERE cart.status & %d AND cart.date >= '%s' AND cart.date <= '%s' )",
            Cart::STATUS_PROCESSED,
            $year_start,
            $today
        );

        $query
            ->withColumn($subquery, 'ydtSales')
            ->groupById()
            ->useUserProfileQuery('user_profile', Criteria::INNER_JOIN)
                ->filterBySurname(null, Criteria::ISNOTNULL)
                ->_or()
                ->filterByGivenNames(null, Criteria::ISNOTNULL)
                ->_or()
                ->filterByEmail(null, Criteria::ISNOTNULL)
            ->endUse();

        if ($realm = $request->query->get('realm')) {
            $query
                ->filterByRealm($realm);
         }

        if ($affiliate_id = $request->query->get('affiliate_id')) {
            $query->filterByAffiliateId($affiliate_id);
        }

        $count_total = $query->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $count_filtered = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $customers = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array_merge(
            $this->getTemplateParams(),
            array(
                'draw' => $request->query->get('draw'),
                'count_total' => $count_total,
                'count_filtered' => $count_filtered,
                'customers' => $customers
            )
        );
    }

    /**
     * @Route("/{id}", name="customer", requirements={"id": "\d+"})
     * @Template("DzangocartCoreBundle:Customer:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $customer = $this->getCustomer($request, $id);

        return array_merge(
            $this->getTemplateParams(),
            array(
                'customer' => $customer
            )
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
        $filters = $this->createForm(
            new OrdersFiltersType(),
            array(
                'date_from' => $this->getStore()->getCreatedAt(null),
                'date_to' => new DateTime()
            )
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'customer' => $this->getCustomer($request, $id),
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/{id}/purchases", name="customer_purchases")
     * @Template("DzangocartCoreBundle:Customer:purchases.html.twig")
     */
    public function purchasesAction(Request $request, $id)
    {
        $filters = $this->createForm(
            new SalesFiltersType(),
            array(
                'date_from' => $this->getStore()->getCreatedAt(null),
                'date_to' => new DateTime()
            )
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'customer' => $this->getCustomer($request, $id),
                'filters' => $filters->createView()
            )
        );
    }

     /**
     * @Route("/{id}/payments", name="customer_payments")
     * @Template("DzangocartCoreBundle:Customer:payments.html.twig")
     */
    public function paymentsAction(Request $request, $id)
    {
        $filters = $this->createForm(
            new StorePaymentsFiltersType(
                $this->getStore(),
                $this->get('translator'),
                $request->getLocale()
            ),
            array(
                'date_from' => $this->getStore()->getCreatedAt(null),
                'date_to' => new DateTime()
            )
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'customer' => $this->getCustomer($request, $id),
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/{id}/cart", name="customer_carts")
     * @Template("DzangocartCoreBundle:Customer:carts.html.twig")
     */
    public function cartsAction(Request $request, $id)
    {
        return array_merge(
            $this->getTemplateParams(),
            array(
                'customer' => $this->getCustomer($request, $id)
            )
        );
    }

    /**
     * @Route("/search/{search}", name="customer_search", defaults={ "_format": "json" })
     * @Template("DzangocartCoreBundle:Order:search.json.twig")
     */
    public function searchAction(Request $request, $search = '%QUERY')
    {
        $customers = $this->getQuery()
            ->useUserProfileQuery('user_profile')
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
            ->distinct();

        return array(
            'customers' => $customers->find()
        );
    }

    protected function getQuery()
    {
        return CustomerQuery::create()
            ->innerJoinCart('cart')
            ->innerJoinUserProfile('user_profile');
    }

    protected function getSortColumns()
    {
        return array(
            1 => 'customer.realm',
            2 => array('user_profile.surname', 'user_profile.given_names'),
            3 => 'user_profile.gender',
            4 => 'user_profile.email'

        );
    }

    protected function getSearchColumns()
    {
        return array(
            'realm' => 'customer.realm LIKE "%%%s%%"',
            //TODO [JP 7-24-2014] only search surname, need search by given_names and email.
            'name' => 'user_profile.surname LIKE "%%%s%%"',
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
        return $request->query->get('customer_filters', array());
    }

    /**
     * Returns the sort order parameters in a format that can be passed
     * as the argument to the CustomerQuery#sort method.
     *
     * If the request query provides no sort order indications, this method
     * should return an array reflecting the default sort order (by date).
     *
     * @return array
     */
    protected function getSortOrder(Request $request)
    {
        $sort = array();

        $order = $request->query->get('order', array());

        $columns = $this->getSortColumns();

        foreach ($order as $setting) {

            $index = $setting['column'];

            if (array_key_exists($index, $columns)) {

                if (!is_array($columns[$index])) {
                    $columns[$index] = array($columns[$index]);
                }

                foreach ($columns[$index] as $sort_column) {
                    $sort[] = array(
                        $sort_column,
                        $setting['dir']
                    );
                }
            }
        }

       if (empty($sort)) {
            $sort[] = array(
                'user_profile.surname',
                'asc'
            );

            $sort[] = array(
                'user_profile.given_names',
                'asc'
            );
        }

        return $sort;
    }
}
