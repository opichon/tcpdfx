<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\UserQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 */
class UserController extends BaseController
{
    /**
     * @Route("/", name="users")
     * @Template("DzangocartCoreBundle:User:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        return array(
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/list", name="users_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:User:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = UserQuery::create();

        if ($store = $this->getStore()) {
            $query
                ->filterByRealm($store->getRealm());
        } elseif ($realm = $request->query->get('realm')) {
            $query
                ->filterByRealm($realm);
        }

        $total_count = $query->count();

        $search = $request->query->get('search');

        $query->datatablesSearch(
            $search['value'],
            $this->getDataTablesSearchColumns()
        );

        $filtered_count = $query->count();

        $limit = min(100, $request->query->get('length'));
        $offset = max(0, $request->query->get('start'));

        $users = $query
            ->dataTablesSort($request->query, $this->getDataTablesSortColumns())
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'draw' => $request->query->get('draw'),
            'start' => 0,
            'recordsTotal' => $total_count,
            'recordsFiltered' => $filtered_count,
            'users' => $users
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
