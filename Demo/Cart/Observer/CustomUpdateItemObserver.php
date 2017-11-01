<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Demo\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock as ResourceStock;

class CustomUpdateItemObserver implements ObserverInterface
{

    protected $request;
    protected $_quoteItemModel;
    
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\App\Request\Http $request,
        \Demo\Cart\Model\QuoteItem $quoteItem
    ) {
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        $this->request = $request;
        $this->_quoteItemModel = $quoteItem;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->request->getModuleName() == 'checkout') {
            $websiteId = $this->stockConfiguration->getDefaultScopeId();
            $info = $observer->getEvent()->getInfo()->toArray();

            if (count($info) > 0) {
                foreach ($info as $itemId => $itemInfo) {
                    $registeredItems= [];
                    //get old quote item
                    $quoteItemOld = $this->_quoteItemModel->getOldQty($itemId);
                    //get list quote item with parent_id $itemId
                    $quoteItem = $this->_quoteItemModel->getQuoteItem($itemId);
                    $operator = '-';
                    $qty = (int) $itemInfo['qty'] - (int) $quoteItemOld[0]['qty'];
                    $qty = abs($qty);
                    if ((int) $itemInfo['qty'] <= (int) $quoteItemOld[0]['qty']) {
                        $operator = '+';
                    }
                    if (count($quoteItem) > 0){
                        foreach ($quoteItem as $key => $value) {
                            $registeredItems[$value['product_id']] = (int) $value['qty'] * $qty;
                        }
                    } else {
                        $registeredItems[$quoteItemOld[0]['product_id']] = $qty;
                    }
                    $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, $operator);
                }
            }
        }
    }
}
