<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCategory;

class Category extends BaseCategory
{
    public function getPcode()
    {
        return $this->pcode;
    }

    public function setPcode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pcode !== $v) {
            $this->pcode = $v;
            $this->modifiedColumns[] = CategoryPeer::PCODE;
        }

        return $this;
    }
}
