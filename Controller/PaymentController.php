<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\PaymentsFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\PaymentQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/payment")
 */
class PaymentController extends BaseController
{
    /**
     * @Route("/", name="payments")
     * @Template("DzangocartCoreBundle:Payment:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $filters = $this->getFiltersForm($request);

        return array_merge(
            $this->getTemplateParams(),
            array(
                'template' => $this->getBaseTemplate(),
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/list", name="payments_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Payment:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        if ($store_id = $request->query->get('store_id')) {
            $query
                ->useGatewayQuery()
                    ->filterByStoreId($store_id)
                ->endUse();
        }

        if ($customer_id = $request->query->get('customer_id')) {
            $query
                ->useOrderQuery()
                    ->filterByCustomerId($customer_id)
                ->endUse();
        }

        $count_total = $query->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $count_filtered = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $payments = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'draw' => $request->query->get('draw'),
            'count_total' => $count_total,
            'count_filtered' => $count_filtered,
            'payments' => $payments,
            'param' => $this->getTemplateParams()
        );
    }

    protected function getFiltersForm(Request $request)
    {
        return $this->createForm(
            new PaymentsFiltersType(),
            array(
                'date_from' => (new DateTime())->modify('first day of this month'),
                'date_to' => new DateTime()
            )
        );
    }

    protected function getQuery()
    {
        return PaymentQuery::create()
                ->useGatewayQuery()
                    ->innerJoinService('gateway_service')
                    ->innerJoinStore('store')
                ->endUse()
            ->innerJoinGateway();
    }

    protected function getSortColumns()
    {
        return array(
            1 => 'payment.createdAt',
            2 => 'store.name',
            3 => 'payment.orderId',
            4 => 'gateway_service.name',
            6 => 'payment.status'
        );

    }

    protected function getSearchColumns()
    {
        return array(
            'store' => 'store.Id = %d',
            'order_id' => 'payment.orderId LIKE "%s%%"',
            'date_from' => 'payment.createdAt >= "%s 00:00:00"',
            'date_to' => 'payment.createdAt <= "%s 23:59:59"',
            'service_id' => 'gateway_service.id = "%s%%"',
            'status' => $this->getStatusQueryString()
        );
    }

    protected function getStatusQueryString()
    {
        $request = $this->container->get('request');

        $status = $request->query->get('payments_filters')['status'];

        if ($status == 0) {
            return 'payment.status = "%s%%"';
        }

        return 'payment.status & "%s%%"';
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
        return $request->query->get('payments_filters', array());
    }

    /**
     * Returns the sort order parameters in a format that can be passed
     * as the argument to the PaymentQuery#sort method.
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
                'payment.createdAt',
                'asc'
            );
        }

        return $sort;
    }

}
