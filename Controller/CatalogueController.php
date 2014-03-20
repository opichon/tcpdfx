<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\CategoryEditType;
use Dzangocart\Bundle\CoreBundle\Model\CategoryQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CatalogueController extends BaseController
{
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


        if (!$category) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('catalogue.category.show.error.not_found', array(), 'catalogue', $request->getLocale())
            );
        }

        $form = $this->createForm(
            new CategoryEditType($this->getStore()), $category, array( 'action' => $this->generateUrl('category_edit', array('id' => $id)))
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
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate()
        );
    }
}

