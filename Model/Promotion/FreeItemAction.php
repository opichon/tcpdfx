<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Promotion;


class FreeItemAction extends Action
{
    public function __construct()
    {
        parent::__construct();
        $this->setClassKey(ActionPeer::CLASSKEY_1);
    }

}
