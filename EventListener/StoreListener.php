<?php

namespace Dzangocart\Bundle\CoreBundle\EventListener;

use Dzangocart\Bundle\CoreBundle\Exception\UnknownStoreException;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class StoreListener extends ContainerAware
{
    private $containerInterface;
    
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }
    
    public function onFilterController(FilterControllerEvent $event)
    {
        $host_parts = array();
        $host = $event->getRequest()->getHost();
        $host_parts = explode('.', $host);
        $store_domain = $host_parts[0];
    }
    
    protected function getStore() 
    {
        
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!($exception instanceof UnknownStoreException)) {
            return;
        } else {
            die();
        } 
    }
}
