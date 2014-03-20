<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

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
}


