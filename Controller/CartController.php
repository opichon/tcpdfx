<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use DateTime;

use Dzangocart\Bundle\CoreBundle\Form\Type\CartsFiltersType;
use Dzangocart\Bundle\CoreBundle\Model\Cart;
use Dzangocart\Bundle\CoreBundle\Model\CartQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/cart")
 */
class CartController extends BaseController
{
    /**
    * @Route("/", name="carts")
    * @Template("DzangocartCoreBundle:Cart:index.html.twig")
    */
    public function indexAction(Request $request)
    {
        $filters = $this->createForm(
            new CartsFiltersType(),
            array(
                'date_from' => (new DateTime())->modify('first day of this month'),
                'date_to' => new DateTime()
            )
        );

        return array(
            'store' => $this->getStore(),
            'filters' => $filters->createView(),
            'template' => $this->getBaseTemplate()
        );
    }

    /**
     * @Route("/list", name="cart_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template("DzangocartCoreBundle:Cart:list.json.twig")
     */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        if ($store_id = $request->query->get('store_id')) {
            $query->filterByStoreId($store_id);
        }

        $total_count = $query->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $query->innerJoinStore('store');

        $filtered_count = $query->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $carts = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'start' => 0,
            'total_count' => $total_count,
            'filtered_count' => $filtered_count,
            'carts' => $carts
        );
    }
    /**
     * @Route("/{id}", requirements={"id": "\d+"}, name="cart_show")
     * @Template("DzangocartCoreBundle:Cart:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $cart = $this->getQuery()
            ->findPk($id);

        if (!$cart) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans(
                    'cart.show.error.not_found',
                    array(),
                    'cart',
                    $request->getLocale()
                )
            );
        }

        return array(
            'cart' => $cart,
            'template' => $this->getBaseTemplate()
        );
    }

    protected function getSortColumns()
    {
        return array(
            1 => 'cart.date',
            2 => 'cart.id',
            3 => 'store.Name',
            4 => array('user_profile.surname', 'user_profile.given_names'),
            5 => 'cart.amount_excl',
            6 => 'cart.tax_amount',
            7 => 'cart.amount_incl'
        );
    }

    protected function getSearchColumns()
    {
        return array(
            'order_id' => 'cart.id = %d',
            'store' => 'cart.storeId = %d',
            'customer_id' => 'cart.customerId = %d',
            'date_from' => 'cart.date >= "%s 00:00:00"',
            'date_to' => 'cart.date <= "%s 23:59:59"'
        );
    }

    protected function getQuery()
    {
        return CartQuery::create()
            ->filterByStatus(Cart::STATUS_OPEN)
            ->useCustomerQuery()
                ->innerJoinUserProfile('user_profile')
            ->endUse();
    }

    /**
     * Returns the sort order parameters in a format that can be passed
     * as the argument to the ItemQuery#sort method.
     *
     * If the request query provides no sort order indications, this method
     * should return an array reflecting the default sort order (by date).
     *
     * @return array
     */
    protected function getSortOrder(Request $request)
    {
        $sort = array();

        $order = $request->query->get('order', array());

        $columns = $this->getSortColumns();

        foreach ($order as $setting) {

            $index = $setting['column'];

            if (array_key_exists($index, $columns)) {

                if (!is_array($columns[$index])) {
                    $columns[$index] = array($columns[$index]);
                }

                foreach ($columns[$index] as $sort_column) {
                    $sort[] = array(
                        $sort_column,
                        $setting['dir']
                    );
                }
            }
        }

       if (empty($sort)) {
            $sort[] = array(
                'cart.date',
                'asc'
            );
        }

        return $sort;
    }

    protected function getLimit(Request $request)
    {
        return min(100, $request->query->get('length', 10));
    }

    protected function getOffset(Request $request)
    {
        return max($request->query->get('start', 0), 0);;
    }

    protected function getFilters(Request $request)
    {
        return $request->query->get('carts_filters', array());
    }

}
