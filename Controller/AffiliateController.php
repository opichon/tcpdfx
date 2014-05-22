<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\AffiliateType;
use Dzangocart\Bundle\CoreBundle\Form\Type\CustomerFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrderFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\Affiliate;
use Dzangocart\Bundle\CoreBundle\Model\AffiliateQuery;
use Dzangocart\Bundle\CoreBundle\Model\User;

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
     * @Route("/affiliate/{id}", requirements={"id" = "\d+"}, name="affiliate_show")
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

    /**
     *@Route("/affiliate/create", name="affiliate_create")
     *@Template("DzangocartCoreBundle:Affiliate:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $affiliate = new Affiliate();

        $affiliate->setStore($this->getStore());
        $affiliate->setRealm($this->getStore()->getRealm());
        $affiliate->setCreatedAt(new DateTime());

        $form = $this->createForm(
            new AffiliateType(),
            $affiliate,
            array(
                'action' => $this->generateUrl('affiliate_create')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user = $this->createUser();

            $affiliate->setOwnerId($user->getId());
            $affiliate->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'affiliate.create.success',
                    array(),
                    'affiliate',
                    $request->getLocale()
                )
            );

            return $this->redirect($this->generateUrl('affiliates'));
        }

        return array(
            'store' => $this->getStore(),
            'affiliate' => $affiliate,
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
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

    protected function createUser()
    {
        $user = new User();
        $user->save();

        $user->setCode($user->getPrimaryKey());
        $user->setUsername($user->getPrimaryKey().'@dzango.com');
        $user->setRealm($this->getStore()->getRealm());
        $user->setIsActive(1);
        $user->save();

        return $user;
    }
}
