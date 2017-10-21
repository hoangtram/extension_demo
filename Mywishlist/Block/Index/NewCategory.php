<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Mywishlist\Block\Index;

/**
 * Description of NewCategory
 *
 * @author tram
 */
class NewCategory  extends \Magento\Framework\View\Element\Template{
    
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Wish List Category'));
    }
    
    public function getWishlistCategoryById($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Demo\Mywishlist\Model\WishlistCategory')->load($id);
        return $model;
    }
}
