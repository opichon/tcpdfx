<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\GatewaysFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\Gateway\GatewayQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class GatewayController extends BaseController
{
    /**
     * @Route("/gateway", name="gateways")
     * @Template("DzangocartCoreBundle:Gateway:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $filters = $this->createForm(
            new GatewaysFiltersType($request->getLocale())
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
     * @Route("/list", name="gateways_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Gateway:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        if ($store_id = $request->query->get('store_id')) {
            $query
                ->filterByStoreId($store_id);
        }

        $total_count = $query->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $gateways = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array_merge(
            $this->getTemplateParams(),
            array(
                'total_count' => $total_count,
                'filtered_count' => $filtered_count,
                'gateways' => $gateways
            )
        );
    }

    /**
     * @Route("/gateway/{id}", name="gateway", requirements={"id": "\d+"})
     * @Template("DzangocartCoreBundle:Gateway:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $gateway = $this->getGateway($id);

        return array_merge(
            $this->getTemplateParams(),
            array(
                'template' => $this->getBaseTemplate(),
                'gateway' => $gateway
            )
        );
    }

    protected function getQuery()
    {
        return GatewayQuery::create()
            ->joinService()
            ->orderBy('Service.Name');
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
        return $request->query->get('gateways_filters', array());
    }

    protected function getSearchColumns()
    {
        return array(
            'service_id' => 'Service.id LIKE "%%%s%%"',
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
                $sort[] = array(
                    $columns[$index],
                    $setting['dir']
                );
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
            /* FIXME [OP 2014--07-06]}
            1 => 'cart.Date',
            2 => 'item.orderId',
            3 => 'store.Name',
            5 => 'item.name',
            6 => 'item.quantity',
            7 => 'item.currencyId',
            8 => 'item.amount_excl',
            9 => 'item.tax_amount',
            10 => 'item.amount_incl'
            */
        );
    }

    protected function getGateway($id)
    {
        $gateway = $this->getQuery()
            ->findPk($id);

        if (!$gateway) {
            throw $this->createNotFoundException('Gateway not found');
        }

        return $gateway;
    }
}
