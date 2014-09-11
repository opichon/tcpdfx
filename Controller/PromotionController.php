<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\PromotionFormType;
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
        $filters = $this->createForm(
            new PromotionFormType(),
            array(
                'date_from' => (new DateTime())->modify('first day of this month'),
                'date_to' => new DateTime()
            )
        );

        return array_merge(
            $this->getTemplateParams(),
            array(
                'filters' => $filters->createView()
            )
        );
    }

    /**
     * @Route("/promotion/list", name="promotions_list")
     * @Template("DzangocartCoreBundle:Promotion:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $store_id = $request->query->get('store_id');

        $query = $this->getQuery()
            ->joinWithI18n($request->getLocale());

        if ($store_id = $request->query->get('store_id')) {
            $query->filterByStoreId($store_id);
        }

        $total_count = $query->count();

        $query->filter(
            $request->query->get('promotion'),
            $this->getDataTablesSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = min(100, $request->query->get('lenght'));
        $offset = max(0, $request->query->get('start'));

        $promotions = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
                'draw' => $request->query->get('draw'),
                'start' => 0,
                'total_count' => $total_count,
                'filtered_count' => $filtered_count,
                'promotions' => $promotions
            );
    }

    protected function getDatatablesSortColumns()
    {
        return array(
           1 => 'PromotionI18n.name',
           2 => 'promotion.code',
           3 => 'promotion.date_from',
           4 => 'promotion.date_to'
        );
    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'name' => 'PromotionI18n.name LIKE "%%%s%%"',
            'code' => 'promotion.code LIKE "%%%s%%"',
            'date_from' => 'promotion.date_from >= "%s 00:00:00"',
            'date_to' => 'promotion.date_to <= "%s 23:59:59"'
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
            new PromotionFormType(), $promotion, array( 'action' => $this->generateUrl('promotion_edit', array('id' => $id)))
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
            new PromotionFormType(),
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

    protected function getSortOrder(Request $request)
    {
        $sort = array();

        $order = $request->query->get('order', array());

        $columns = $this->getDatatablesSortColumns();

        foreach ($order as $setting) {

            $index = $setting['column'];

            if (array_key_exists($index, $columns)) {

                $column = $columns[$index];

                if (!is_array($column)) {
                    $column = array($column);
                }

                foreach ($column as $c) {
                    $sort[] = array(
                        $c,
                        $setting['dir']
                    );
                }
            }
        }

        if (empty($sort)) {
            $sort[] = array(
                'promotion.id',
                'asc'
            );
        }

        return $sort;
    }
}
