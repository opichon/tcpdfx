<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

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

           $query = AffiliateQuery::create();

            if ($store = $this->getStore()) {
                $query->filterByStore($store);
            } elseif ($store_id = $request->query->get('store_id')) {
                $query->filterByStoreId($store_id);
            }
            $total_count = $query->count();
             
            $query->datatablesSearch(
                $request->query->get('sSearch'),
                $this->getDataTablesSearchColumns()
            );
            
            $query->innerJoinStore('store');

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

        return array(
            'store' => $this->getStore(),
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

}   