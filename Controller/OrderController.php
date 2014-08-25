<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Criteria;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\OrdersFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\CartQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class OrderController extends BaseController
{
    /**
    * @Template()
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
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Template("DzangocartCoreBundle:Order:list.json.twig")
     */
    public function listAction(Request $request)
    {

        $query = $this->getQuery();

        if ($affiliate_id = $request->query->get('affiliate_id')) {
            $query->filterByAffiliateId($affiliate_id);
        }

        if ($customer_id = $request->query->get('customer_id')) {
            $query->filterByCustomerId($customer_id);
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
            ->sort($this->getSortOrder($request))
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

        return array_merge(
            $this->getTemplateParams(),
            array(
                'order' => $order
            )
        );
    }

    protected function getQuery()
    {
        return CartQuery::create('Cart')
            ->processed()
            ->innerJoinStore()
            ->useCustomerQuery()
                ->innerJoinUserProfile('user_profile')
            ->endUse();
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
            'order_id' => 'Cart.id = %d',
            'store' => 'Cart.storeId = %d',
            'customer_id' => 'Cart.customerId = %d',
            'date_from' => 'Cart.date >= "%s 00:00:00"',
            'date_to' => 'Cart.date <= "%s 23:59:59"'
        );
    }

    /**
     * Returns the sort order parameters in a format that can be passed
     * as the argument to the CartQuery#sort method.
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
                'Cart.date',
                'asc'
            );
        }

        return $sort;
    }

    protected function getSortColumns()
    {
        return array(
            1 => 'Cart.date',
            2 => 'Cart.id',
            3 => 'store.Name',
            4 => array('user_profile.surname', 'user_profile.given_names'),
            5 => 'Cart.status',
            6 => 'Cart.amount_excl',
            7 => 'Cart.tax_amount',
            8 => 'Cart.amount_incl'
        );
    }
}
