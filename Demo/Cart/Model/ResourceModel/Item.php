<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Cart\Model\ResourceModel;

/**
 * Description of QuoteItem
 *
 * @author HP
 */
class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('quote_item', 'item_id');
    }
}
