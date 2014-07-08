<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Model\ItemQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\SalesFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/sale")
 */
class SaleController extends BaseController
{
    /**
     * @Route("/", name="sales")
     * @Template("DzangocartCoreBundle:Sale:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $filters = $this->createForm(
            new SalesFiltersType(),
            array(
                'date_from' => (new DateTime())->modify('first day of this month'),
                'date_to' => new DateTime()
            )
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'template' => $this->getBaseTemplate(),
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/list", name="sales_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Sale:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        if ($affiliate_id = $request->query->get('affiliate_id')) {
            $query
                ->useCartQuery()
                    ->filterByAffiliateId($affiliate_id)
                ->endUse();
        }

        if ($customer_id = $request->query->get('customer_id')) {
            $query
                ->useCartQuery()
                    ->filterByCustomerId($customer_id)
                    ->filterByStatus(array('min' => 3))
                ->endUse();
        }

        if ($store_id = $request->query->get('store_id')) {
            $query
                ->useCartQuery()
                    ->filterByStoreId($store_id)
                    ->filterByStatus(array('min' => 3))
                ->endUse();
        }

        $total_count = $query->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $sales = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array_merge(
            $this->getTemplateParams(),
            array(
                'total_count' => $total_count,
                'filtered_count' => $filtered_count,
                'sales' => $sales
            )
        );
    }

    protected function getQuery()
    {
        $query = ItemQuery::create()
            ->innerJoinCart()
            ->useCartQuery()
                ->processed()
                ->useCustomerQuery()
                    ->innerJoinUserProfile('user_profile')
                ->endUse()
            ->endUse()
            ->filterByParentId(null);

        return $query;
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
        return max($request->query->get('start', 0), 0);
    }

    protected function getFilters(Request $request)
    {
        return $request->query->get('sales_filters', array());
    }

    protected function getSearchColumns()
    {
        return array(
            'order_id' => 'item.orderId = %d',
            'store' => 'Cart.storeId = %d',
            'customer_id' => 'Cart.customerId = %d',
            'date_from' => 'Cart.date >= "%s 00:00:00"',
            'date_to' => 'Cart.date <= "%s 23:59:59"',
            'name' => 'item.name LIKE "%%%s%%"'
        );
    }

    /**
     * Returns the sort order parameters in a format that can be passed
     * as the argument to the ItemQuery#sort method.
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
            1 => 'Cart.Date',
            2 => 'item.orderId',
            3 => 'store.Name',
            4 => array('user_profile.surname', 'user_profile.given_names'),
            5 => 'item.name',
            6 => 'item.quantity',
            7 => 'item.currencyId',
            8 => 'item.amount_excl',
            9 => 'item.tax_amount',
            10 => 'item.amount_incl'
        );
    }
}
