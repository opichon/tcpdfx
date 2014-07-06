<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\PromotionEditType;
use Dzangocart\Bundle\CoreBundle\Model\ItemQuery;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\Promotion;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\PromotionI18nQuery;
use Dzangocart\Bundle\CoreBundle\Model\Promotion\PromotionQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PromotionController extends BaseController
{
    /**
     * @Route("/promotion", name="promotions")
     * @Template("DzangocartCoreBundle:Promotion:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $store_id = $request->query->get('store_id');

            $query = $this->getQuery()
                ->joinWithI18n($request->getLocale());

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

            $promotions = $query
                ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'promotions' => $promotions
            );

            $view = $this->renderView('DzangocartCoreBundle:Promotion:index.json.twig', $data);

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
            1 => 'promotion.id',
            2 => 'promotion.storeId'
        );

    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'promotion.id'
        );
    }

    /**
     * @Route("/promotion/{id}/edit", name="promotion_edit")
     * @Template("DzangocartCoreBundle:Promotion:edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $promotion = $this->getQuery()
            ->joinWithI18n($request->getLocale())
            ->findPk($id);

        if (!$promotion) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('promotion.show.error.not_found', array(), 'promotion', $request->getLocale())
            );
        }

        $form = $this->createForm(
            new PromotionEditType(), $promotion, array( 'action' => $this->generateUrl('promotion_edit', array('id' => $id)))
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $promotion->save();
            $this->get('session')->getFlashBag()->add(
            'promotion.edit.success',
            $this->get('translator')->trans(
                'promotion.edit.success',
                array(),
                'promotion',
                $request->getLocale()
            ));

            return $this->redirect($this->generateUrl('promotions'));
        }

        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/promotion/{id}/delete", name="promotion_delete")
     * @Template("DzangocartCoreBundle:Promotion:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $promotion = $this->getQuery()
            ->findPk($id);

        $promotion_i18n = PromotionI18nQuery::create()->findById($id);

        if (!$promotion) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('promotion.delete.error.not_found', array(), 'promotion', $request->getLocale())
            );
        }

        $items = ItemQuery::create()->filterByPromotionId($id)->find();

        foreach ($items as $item) {
            $item->setPromotionId(null);
            $item->save();
        }

       $promotion->delete();

       $promotion_i18n->delete();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans(
                'promotion.delete.success',
                array(),
                'promotion',
                $request->getLocale()
        ));

        return $this->redirect($this->generateUrl('promotions'));
    }

    /**
     *@Route("/promotion/create", name="promotion_create")
     * @Template("DzangocartCoreBundle:Promotion:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $promotion = new Promotion();

        $promotion->setLocale($request->getLocale());

        $promotion->setStoreId($this->getStore()->getId());

        $form = $this->createForm(
            new PromotionEditType(),
            $promotion,
            array(
                'action' => $this->generateUrl('promotion_create')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $promotion->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'promotion.create.success',
                    array(),
                    'promotion',
                    $request->getLocale()
                )
            );

            return $this->redirect($this->generateUrl('promotions'));
        }

        return array(
            'store' => $this->getStore(),
            'promotion' => $promotion,
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
    }

    protected function getQuery()
    {
        return PromotionQuery::create();
    }
}
