<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\PaymentFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\PaymentQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends BaseController
{
    /**
     * @Route("/payment", name="payments")
     * @Template("DzangocartCoreBundle:Payment:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = $this->getQuery();

            if ($store = $this->getStore()) {
                $query
                    ->useGatewayQuery()
                        ->filterByStore($store)
                    ->endUse();
            } elseif ($store_id = $request->query->get('store_id')) {
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

            $query->innerJoinGateway();

            $total_count = $query->count();

            $query->dataTablesSearch(
                $request->query->get('payment_filters'),
                $this->getDataTablesSearchColumns()
            );

            $filtered_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));

            $payments = $query
                ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'payments' => $payments,
                'param' => $this->getTemplateParams()
            );

            $view = $this->renderView('DzangocartCoreBundle:Payment:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

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
            'status' => 'payment.status = "%s%%"',
        );
    }

    protected function getQuery()
    {
        return PaymentQuery::create('Cart');
    }

    protected function getTemplateParams()
    {
        return array();
    }

}
