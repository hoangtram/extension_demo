<?php

namespace Demo\Cart\Model\ResourceModel\Item;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'item_id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Demo\Cart\Model\QuoteItem', 'Demo\Cart\Model\ResourceModel\Item');
    }

}