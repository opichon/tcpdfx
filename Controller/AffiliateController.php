<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\CustomerFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\AffiliateQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AffiliateController extends BaseController
{
    /**
     * @Route("/affiliate", name="affiliates")
     * @Template("DzangocartCoreBundle:Affiliate:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = $this->getQuery();

            if ($store_id = $request->query->get('store_id')) {
                $query->filterByStoreId($store_id);
            }

            $total_count = $query->count();

            $query->datatablesSearch(
                $request->query->get('sSearch'),
                $this->getDataTablesSearchColumns()
            );

            $filtered_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));

            $affiliates = $query
                ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'affiliates' => $affiliates
            );

            $view = $this->renderView('DzangocartCoreBundle:Affiliate:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

        return array_merge(
            $this->getTemplateParams(),
            array(
                'template' => $this->getBaseTemplate()
            )
        );
    }

    /**
     * @Route("/affiliate/{id}", name="affiliate_show")
     * @Template("DzangocartCoreBundle:Affiliate:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

        return array(
            'store' => $this->getStore(),
            'affiliate' => $affiliate,
            'template' => $this->getBaseTemplate()
        );
    }

     /**
     * @Route("/affiliate/{id}/order",name="affiliate_orders")
     * @Template("DzangocartCoreBundle:Affiliate:orders.html.twig")
     */
    public function ordersAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);
        $form = $this->createForm(
            new OrderFiltersType());

        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'affiliate' => $affiliate,
            'template' => $this->getBaseTemplate()

        );
    }

    /**
     * @Route("/affiliate/{id}/sale", name="affiliate_sales")
     * @Template("DzangocartCoreBundle:Affiliate:sales.html.twig")
     */
    public function salesAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

        return array(
            'store' => $this->getStore(),
            'affiliate' => $affiliate,
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/affiliate/{id}/customer", name="affiliate_customer")
     * @Template("DzangocartCoreBundle:Affiliate:customers.html.twig")
     */
    public function customerAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

        $form = $this->createForm(
            new CustomerFiltersType());

        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'affiliate' => $affiliate,
            'template' => $this->getBaseTemplate()
        );
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'affiliate.storeId',
            2 => 'affiliate.name',
            3 => 'affiliate.website'
        );

    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'affiliate.name'
        );
    }

    protected function getAffiliate(Request $request, $id)
    {
        $affiliate = $this->getQuery()
            ->findPk($id);

        if (!$affiliate) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('affiliate.error.not_found', array(), 'affiliate', $request->getLocale())
            );
        }

        return $affiliate;
    }

    protected function getQuery()
    {
        return AffiliateQuery::create()
            ->innerJoinStore('store');
    }

    protected function getTemplateParams()
    {
        return array();
    }

}
