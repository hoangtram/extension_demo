<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Demo\Cart\Helper;
/**
 * Description of CustomChangeQtyProduct
 *
 * @author HP
 */
class CustomChangeQtyProduct extends \Magento\Framework\App\Helper\AbstractHelper{
    
    const PRODUCT_TYPE_SIMPLE = 'simple';
    const PRODUCT_TYPE_CONFIGURABLE = 'configurable';
    
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        parent::__construct($context);
    }
    
    public function updateQtyProduct($items, $action)
    {
        $websiteId = $this->stockConfiguration->getDefaultScopeId();
        if (!empty($items)) {
            $productType = $items[0]->getProductType();
            // case add item
            if ($action == 'updateItemOptions' && $productType == 'simple') {
                return false;
            }
            $registeredItems = $this->renderItems($items, $productType);
            $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '-');
        }
    }
    
    public function renderItems($items, $productType) {
        $registeredItems = [];
        $qtyParent = 1;
        if ($productType !== self::PRODUCT_TYPE_SIMPLE ){
            $qtyParent = $items[0]->getQtyToAdd() ;
        }

        foreach ($items as $key => $value) {
            if ($value->getProductType() != 'simple') {
                continue;
            } else {
                $registeredItems[$value->getProductId()] = $value->getQtyToAdd() * $qtyParent;
            }
        } 
                
        return $registeredItems;
    }
    
}
