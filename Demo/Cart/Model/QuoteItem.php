<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Cart\Model;

/**
 * Description of QuoteItem
 *
 * @author HP
 */
class QuoteItem extends \Magento\Framework\Model\AbstractModel{
    const ProductypeConfigurable = 'configurable';

    protected function _construct()
    {
        $this->_init('Demo\Cart\Model\ResourceModel\Item');
    }
    
//    get old quote item by itemID
    public function getOldQty($itemId){
        $quoteItem = $this->getCollection()
            ->addFieldToFilter('item_id', ['eq' => $itemId])
            ->getData();
        return $quoteItem;
    }
    
//    get quote item by parentItemId
    public function getQuoteItem($itemId){
        $quoteItem = $this->getCollection()
            ->addFieldToFilter('parent_item_id', ['eq' => $itemId])
            ->getData();
        return $quoteItem;
    }
    
    //get quote_item and quote save before $now
    public function getAttributeQuoteItem($now)
    {
        $collection = $this->getCollection();
        $collection
            ->getSelect()
            ->join(
                ['quote' => $collection->getTable('quote')],
                'main_table.quote_id = quote.entity_id',
                ['quote.entity_id'=>'quote.entity_id'])
            ->where("quote.is_active = 1")
            ->where("quote.items_count > 0")
            ->where("CASE quote.updated_at WHEN '0000-00-00 00:00:00' THEN quote.created_at <= '$now' ELSE quote.updated_at <= '$now' END")
            ->where("main_table.cron_status is null")
            ->order("main_table.parent_item_id"," asc")
            ->order("main_table.item_id"," asc");

//            echo $collection->getSelect();die;
        $attributes = $collection->getData();

        return $attributes;
    }
}
