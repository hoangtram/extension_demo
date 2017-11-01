<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Demo\Cart\Model;

use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Api\StockConfigurationInterface;
use Magento\CatalogInventory\Api\StockManagementInterface;
use Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface;
use Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock as ResourceStock;
/**
 * Description of StockManagement
 *
 * @author HP
 */
class StockManagement extends \Magento\CatalogInventory\Model\StockManagement{
    public $customqtyCounter;

    public $customStockState;
    
    public function __construct(
        ResourceStock $stockResource,
        StockRegistryProviderInterface $stockRegistryProvider,
        \Magento\CatalogInventory\Model\StockState $stockState,
        StockConfigurationInterface $stockConfiguration,
        ProductRepositoryInterface $productRepository,
        QtyCounterInterface $qtyCounter,
        \Magento\Framework\App\State $customStockState
    ) {
        $this->customqtyCounter = $qtyCounter;
        $this->customStockState = $customStockState;
        parent::__construct(
            $stockResource,
            $stockRegistryProvider,
            $stockState,
            $stockConfiguration,
            $productRepository,
            $qtyCounter
        );
    }
    
    public function registerProductsSale($items, $websiteId = null)
    {
        //if (!$websiteId) {
        $websiteId = $this->stockConfiguration->getDefaultScopeId();
        //}
        $this->getResource()->beginTransaction();
        $lockedItems = $this->getResource()->lockProductsStock(array_keys($items), $websiteId);
        $fullSaveItems = $registeredItems = [];
        foreach ($lockedItems as $lockedItemRecord) {
            $productId = $lockedItemRecord['product_id'];
            /** @var StockItemInterface $stockItem */
            $orderedQty = $items[$productId];
            $stockItem = $this->stockRegistryProvider->getStockItem($productId, $websiteId);
            $canSubtractQty = $stockItem->getItemId() && $this->canSubtractQty($stockItem);
            if (!$canSubtractQty || !$this->stockConfiguration->isQty($lockedItemRecord['type_id'])) {
                continue;
            }
            if (!$stockItem->hasAdminArea()
                && !$this->stockState->checkQty($productId, $orderedQty, $stockItem->getWebsiteId())
            ) {
                $this->getResource()->commit();
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Not all of your products are available in the requested quantity.')
                );
            }
            if ($this->canSubtractQty($stockItem)) {
                $stockItem->setQty($stockItem->getQty() - $orderedQty);
            }
            $registeredItems[$productId] = $orderedQty;
            if (!$this->stockState->verifyStock($productId, $stockItem->getWebsiteId())
                || $this->stockState->verifyNotification(
                    $productId,
                    $stockItem->getWebsiteId()
                )
            ) {
                $fullSaveItems[] = $stockItem;
            }
        }
        if ($this->customStockState->getAreaCode() == 'adminhtml') {
            $this->customqtyCounter->correctItemsQty($registeredItems, $websiteId, '-');
        }
        $this->getResource()->commit();
        return $fullSaveItems;
    }
}
