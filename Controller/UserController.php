<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\UserQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    /**
     * @Route("/user", name="users")
     * @Template("DzangocartCoreBundle:User:index.html.twig")
     */
    public function indexAction(Request $request)
    {
       if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = UserQuery::create();

            if ($store = $this->getStore()) {
                $query
                    ->filterByRealm($store->getRealm());
            } elseif ($realm = $request->query->get('realm')) {
                $query
                    ->filterByRealm($realm);
            }

            $total_count = $query->count();

            $query->datatablesSearch(
                $request->query->get('sSearch'),
                $this->getDataTablesSearchColumns()
            );

            $filtered_count = $query->count();

            $limit = min(100, $request->query->get('iDisplayLength'));
            $offset = max(0, $request->query->get('iDisplayStart'));

            $users = $query
                ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($limit)
                ->setOffset($offset)
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'users' => $users
            );

            $view = $this->renderView('DzangocartCoreBundle:User:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }

        return array(
            'template' => $this->getBaseTemplate()
        );
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'dzango_user.id',
        );

    }

    protected function getDataTablesSearchColumns()
    {
        return array(
            'dzango_user.id'
        );
    }

    protected function getBaseTemplate()
    {
        return 'DzangocartCoreBundle::layout.html.twig';
    }
}