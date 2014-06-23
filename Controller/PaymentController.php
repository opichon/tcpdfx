<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\PaymentFiltersType;
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
        $form = $this->createForm(
            new PaymentFiltersType($this->getStore())
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'store' => $this->getStore(),
                'template' => $this->getBaseTemplate(),
                'form' => $form->createView()
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

        $query->dataTablesSearch(
            $request->query->get('payment_filters'),
            $this->getDataTablesSearchColumns()
        );

        $count_filtered = $query->count();

        $limit = min(100, $request->query->get('length', 10));
        $offset = max(0, $request->query->get('start', 0));

        $payments = $query
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
            'payments' => $payments,
            'param' => $this->getTemplateParams()
        );
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'payment.orderId',
            2 => 'payment.createdAt'
        );

    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'id' => 'payment.orderId LIKE "%s%%"',
            'date_start' => 'payment.createdAt >= CONCAT("%s%%, 00:00:00")',
            'date_end' => 'payment.createdAt <= CONCAT("%s%%, 23:59:59")',
            'provider_id' => 'gateway.provider_id = "%s%%"',
            'status' => $this->getStatusQueryString(),
        );
    }

    protected function getStatusQueryString()
    {
        $request = $this->container->get('request');

        $status = $request->query->get('payment_filters')['status'];

        if ($status == 0) {
            return 'payment.status = "%s%%"';
        }

        return 'payment.status & "%s%%"';
    }

    protected function getQuery()
    {
        return PaymentQuery::create('Cart')
            ->innerJoinGateway();
    }

    protected function getTemplateParams()
    {
        return array();
    }

}
