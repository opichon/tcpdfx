<?php

namespace Dzangocart\Bundle\CoreBundle\Twig\Extension;

use Twig_Extension;

use Twig_SimpleFilter;

class AddressExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('address', array($this, 'addressFilter')),
        );
    }

    public function addressFilter($address, $format = null, $locale = null)
    {
        $city = $address->getLocality();
        $state = $address->getRegion();
        $zip = $address->getPostalCode();

        return $city . ' ' . $state . ' ' . $zip;
    }

    public function getName()
    {
        return 'address';
    }
}