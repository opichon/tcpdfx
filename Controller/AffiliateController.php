<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\AffiliateType;
use Dzangocart\Bundle\CoreBundle\Form\Type\CustomersFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\OrdersFiltersType;
use Dzangocart\Bundle\CoreBundle\Form\Type\SalesFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\Affiliate;
use Dzangocart\Bundle\CoreBundle\Model\AffiliateQuery;
use Dzangocart\Bundle\CoreBundle\Model\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class AffiliateController extends BaseController
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return array_merge(
            $this->getTemplateParams(),
            array(
                'template' => $this->getBaseTemplate()
            )
        );
    }

    /**
     * @Template("DzangocartCoreBundle:Affiliate:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        if ($store_id = $request->query->get('store_id')) {
            $query->filterByStoreId($store_id);
        }

        $total_count = $query->count();

        $search = $request->query->get('search');

        $query->datatablesSearch(
            $search['value'],
            $this->getDataTablesSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = min(100, $request->query->get('length'));
        $offset = max(0, $request->query->get('start'));

        $affiliates = $query
            ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array_merge(
            $this->getTemplateParams(),
            array(
                'draw' => $request->query->get('draw'),
                'start' => 0,
                'recordsTotal' => $total_count,
                'recordsFiltered' => $filtered_count,
                'affiliates' => $affiliates
            )
        );
    }

    /**
     * @Template("DzangocartCoreBundle:Affiliate:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

        return array_merge(
            $this->getTemplateParams(),
            array(
                'affiliate' => $affiliate,
            )
        );
    }

     /**
     * @Template("DzangocartCoreBundle:Affiliate:orders.html.twig")
     */
    public function ordersAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

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
                'affiliate' => $affiliate,
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Template("DzangocartCoreBundle:Affiliate:sales.html.twig")
     */
    public function salesAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

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
                'affiliate' => $affiliate,
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Template("DzangocartCoreBundle:Affiliate:customers.html.twig")
     */
    public function customerAction(Request $request, $id)
    {
        $affiliate = $this->getAffiliate($request, $id);

        $filters = $this->createForm(
            new CustomersFiltersType());

        return array_merge(
            $this->getTemplateParams(),
            array(
                'affiliate' => $affiliate,
                'filters' => $filters->createView()
            )
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
                'action' => $this->generateUrl('store_affiliate_create')
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

            return $this->redirect($this->generateUrl('store_affiliates'));
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
