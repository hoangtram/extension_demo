<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Mywishlist\Block\Customer\Wishlist\Item\Column;

/**
 * Description of WishlistCategory
 *
 * @author tram
 */
class WishlistCategory extends \Magento\Framework\View\Element\Template
{    
    protected $_categoryFactory;
        
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Demo\Mywishlist\Model\ResourceModel\WishlistCategory\CollectionFactory $categoryFactory,        
        array $data = []
    )
    {    
        $this->_categoryFactory = $categoryFactory;    
        parent::__construct($context, $data);
    }
    
    public function getWishlistCategoryCollection()
    {
        $collection = $this->_categoryFactory->create();
        return $collection;
    }
}

