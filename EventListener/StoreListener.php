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
    private $containerInterface;
    
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }
    
    public function onFilterController(FilterControllerEvent $event)
    {
        if(!in_array($event->getRequest()->getHost(), array('admin.dzangocart.org', 'admin.dzangocart.net', 'admin.dzangocart.com', 'api.dzangocart.org', 'api.dzangocart.net', 'api.dzangocart.com'))) {
            if (!$this->getStore()) {
                throw new UnknownStoreException('There is no store of this domain.');
            }
        }
    }
    
    public function getStore()
    {
        $request = $this->containerInterface->get('request');
        $host_parts = array();
        $host = $request->getHost();
        $host_parts = explode('.', $host);
        $store_domain = $host_parts[0];

        $store= StoreQuery::create()->findOneByDomain($store_domain);
        if($store) {
            return StoreQuery::create()->findPk($store->getId());
        } else {
            return ;
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
