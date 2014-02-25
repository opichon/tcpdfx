<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\CustomerQuery;
use Dzangocart\Bundle\CoreBundle\Form\Type\CustomerFiltersType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends BaseController
{
    /**
     * @Route("/customer", name="customers")
     * @Template("DzangocartCoreBundle:Customer:index.html.twig")
     */
   
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = CustomerQuery::create();
                
//            if ($store = $this->getStore()) {
//                $query->filterByStore($store);
//            } elseif ($store_id = $request->query->get('store_id')) {
//                $query->filterByStoreId($store_id);
//            }

            $total_count = $query->count();
            
            $query->datatablesSearch(
                $request->query->get('customer_filters'),
                $this->getDataTablesSearchColumns()
            );

            $filtered_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));
            // TODO Get 10 customers instances -- temporary code
            $customers = CustomerQuery::create('Customer');

            $customers = $query
                ->datatablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();
              
            // Total number of Customer instances
	        $total_count = CustomerQuery::create()
	 
                ->count();
	 
           // TODO Number of Customer instances after filters are applied
	 
            $filtered_count = $total_count;
	
            $data = array(
	        'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'customers' => $customers
            );
            
            
            $view = $this->renderView('DzangocartCoreBundle:Customer:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }
         $form = $this->createForm(
            new CustomerFiltersType());
        
        return array(
            'store' => $this->getStore(),
            'form' => $form->createView(),
            'template' => $this->getBaseTemplate());
    }

    /**
     * @Route("/customer/{id}", name="customer_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {

    }
    
     protected function getDataTablesSortColumns()
    {
        return array(
            1 => 'customer.id',
            2 => 'customer.realm',
            3 => 'customer.code',

        );
    }
    protected function getDataTablesSearchColumns()
    {
        return array(
            'id' => 'customer.id LIKE "%s%%"',
            'customer_name' => 'customer.realm LIKE "%%%s%%"',
        );
    }
}


