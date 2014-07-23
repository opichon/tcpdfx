<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function getStore()
    {
    }

    protected function getBaseTemplate()
    {
        return 'DzangocartCoreBundle::layout.html.twig';
    }

    protected function getTemplateParams()
    {
        return array(
            'template' => $this->getBaseTemplate()
        );
    }
}
