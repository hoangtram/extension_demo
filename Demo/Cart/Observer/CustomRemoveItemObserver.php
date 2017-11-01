<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Demo\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock as ResourceStock;

class CustomRemoveItemObserver implements ObserverInterface
{
    protected $request;
    
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        $this->request = $request;
    }

    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->request->getModuleName() == 'checkout') {
            $websiteId = $this->stockConfiguration->getDefaultScopeId();
            $registeredItems = [];
            $items = $observer->getEvent()->getQuoteItem();
            if ($items) {
                $qtyParent = 1;
                if ($items->getProductType() !== 'simple'){
                    $qtyParent = $items->getQty() ;
                }

                if ($items->getHasChildren()) {
                    //list of products in the group
                    foreach ($items->getChildren() as $child) {
                        $registeredItems[$child->getProductId()] = $child->getQty() * $qtyParent;
                    }
                } else {
                    //product simple
                    $registeredItems[$items->getProductId()] = $items->getQty();
                }
            }
            $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '+');
        }
    }
}