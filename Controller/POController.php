<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\POFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\Payment;
use Dzangocart\Bundle\CoreBundle\Model\PaymentQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/po")
 */
class POController extends BaseController
{
    /**
     * @Route("/", name="po")
     * @Template("DzangocartCoreBundle:PO:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $filters = $this->getFiltersForm($request);

        return array_merge(
            $this->getTemplateParams(),
            array(
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/list", name="po_transactions_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:PO:list.json.twig")
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

        return array_merge(
            $this->getTemplateParams(),
            array(
                'draw' => $request->query->get('draw'),
                'count_total' => $count_total,
                'count_filtered' => $count_filtered,
                'payments' => $payments
            )
        );
    }

    protected function getFiltersForm(Request $request)
    {
        return $this->createForm(
            new POFiltersType(),
            array(
                'date_from' => (new DateTime())->modify('first day of this month'),
                'date_to' => new DateTime()
            )
        );
    }

    protected function getQuery()
    {
        return PaymentQuery::create()
            ->filterByTypeId(Payment::TYPE_PO)
            ->useGatewayQuery()
                ->innerJoinStore('store')
            ->endUse()
            ->useOrderQuery()
                ->innerJoinPOTransaction('po_transaction')
            ->endUse();
    }

    protected function getSortColumns()
    {
        return array(
            1 => 'payment.createdAt',
            2 => 'store.name',
            3 => 'payment.orderId',
            4 => 'po_transaction.amount',
            5 => 'po_transaction.bank',
            6 => 'po_transaction.type',
            7 => 'po_transaction.chequeNumber'
        );

    }

    protected function getSearchColumns()
    {
        return array(
            'store' => 'store.Id = %d',
            'order_id' => 'payment.orderId LIKE "%s%%"',
            'date_from' => 'payment.createdAt >= "%s 00:00:00"',
            'date_to' => 'payment.createdAt <= "%s 23:59:59"',
            'bank' => 'po_transaction.bank LIKE "%%%s%%"',
            'cheque' => 'po_transaction.chequeNumber = %d'
        );
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
        return $request->query->get('po_filters', array());
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
