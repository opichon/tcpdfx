<?php

namespace Dzangocart\Bundle\CoreBundle\EventListener;

use Dzangocart\Bundle\CoreBundle\Exception\UnknownStoreException;
use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class StoreListener extends ContainerAware
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onFilterController(FilterControllerEvent $event)
    {
        if($this->container->getParameter('is_store_enable')) {
            if (!$this->getStore()) {
                throw new UnknownStoreException('There is no store of this domain.');
            }
        }
    }
    
    public function getStore()
    {
        $request = $this->container->get('request');
        $host_parts = array();
        $host = $request->getHost();
        $host_parts = explode('.', $host);
        $store_domain = $host_parts[0];

        $store = StoreQuery::create()->findOneByDomain($store_domain);
        if($store) {
            return $store;
        } else {
            return NULL;
        }

        
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!($exception instanceof UnknownStoreException)) {
            return;
        } else {
            die;
        } 
    }
}
