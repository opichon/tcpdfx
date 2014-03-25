<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\CategoryEditType;
use Dzangocart\Bundle\CoreBundle\Model\CategoryQuery;
use Dzangocart\Bundle\CoreBundle\Model\PackComponentQuery;
use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CatalogueController extends BaseController
{
    protected $store ;

    /**
     * @Route("/catalogue", name="catalogue")
     * @Template("DzangocartCoreBundle:Catalogue:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        return array(
            'store' => $this->getStore(),
            'template' => $this->getBaseTemplate()

        );
    }

    /**
     * @Route("/catalogue2", name="catalogue2")
     * @Template("DzangocartCoreBundle:Catalogue:index2.html.twig")
     */
    public function catalogue2Action(Request $request)
    {
        $catalogue = CategoryQuery::create()
            ->findRoot($this->getStore()->getId());

        return array(
            'store' => $this->getStore(),
            'template' => $this->getBaseTemplate(),
            'catalogue2' => $catalogue
        );
    }

    /**
     * @Route("/store/{id}/catalogue", name="store_catalogue")
     * @Template
     */
    public function catalogueAction(Request $request, $id)
    {
        $catalogue = CategoryQuery::create()
            ->findRoot($id);

        $data= array(
            'store' => $this->getStore(),
            'catalogue' => $catalogue
        );

        $view = $this->renderView('DzangocartCoreBundle:Catalogue:catalogue.json.twig', $data);

        return new Response($view, 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("category/{id}", name="category")
     * @Template("DzangocartCoreBundle:Catalogue:category.html.twig")
     */
    public function categoryAction(Request $request, $id)
    {
        $category = CategoryQuery::create()
            ->findPk($id);

        return array(
            'store' => $this->getStore(),
            'category' => $category,
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("category/{id}/edit", name="category_edit")
     * @Template("DzangocartCoreBundle:Catalogue:category_edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $category = CategoryQuery::create()
            ->findPk($id);


        $packs = PackComponentQuery::create()
            ->filterByCategoryId($id)
            ->find();

        if (!$category) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('catalogue.category.show.error.not_found', array(), 'catalogue', $request->getLocale())
            );
        }

        if (!$this->store = $this->getStore()) {
            $this->store = StoreQuery::create()
                ->filterByCategory($category)
                ->findOne();
        }

        $form = $this->createForm(
            new CategoryEditType($this->store), $category, array( 'action' => $this->generateUrl('category_edit', array('id' => $id)))
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $category->save();
            $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans(
                'catalogue.category.edit.success',
                array(),
                'catalogue',
                $request->getLocale()
            ));

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }
        
        return array(
            'packs' => $packs,
            'category' =>$category,
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
    }
}
