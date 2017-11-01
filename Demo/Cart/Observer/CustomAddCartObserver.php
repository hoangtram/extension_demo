<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Demo\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomAddCartObserver implements ObserverInterface
{
    protected $changeQtyProductHelper;

    protected $request;

    public function __construct(
        \Demo\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->changeQtyProductHelper = $changeQtyProductHelper;
        $this->request = $request;
    }

   
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $action  = $this->request->getActionName();
        if ($this->request->getModuleName() == 'checkout') {
            $items = $observer->getEvent()->getItems();
            $this->changeQtyProductHelper->updateQtyProduct($items, $action);
        }
    }
}
