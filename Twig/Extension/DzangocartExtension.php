<?php

namespace Dzangocart\Bundle\CoreBundle\Twig\Extension;

use \Twig_Extension;
use \Twig_Function_Method;

class DzangocartExtension extends Twig_Extension
{
    public function getName()
    {
        return 'dzangoacart';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'app_version' => new Twig_Function_Method($this, 'getVersion', array('is_safe' => array('html'))),
        );
    }

    /**
     * Returns the version number from bin/version.txt
     * TODO [OP 2013-08-01] This code stinks! There's got to be a better way to implement this.
     */
    public function getVersion()
    {
        return file_get_contents(
            dirname(__FILE__) . "/../../../../../../../../bin/version.txt"
        );
    }
}
