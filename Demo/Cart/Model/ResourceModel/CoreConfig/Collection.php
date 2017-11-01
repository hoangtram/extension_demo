<?php

namespace Demo\Cart\Model\ResourceModel\CoreConfig;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Demo\Cart\Model\CoreConfig', 'Demo\Cart\Model\ResourceModel\CoreConfig');
    }

}