<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author tram
 */
namespace Demo\Mywishlist\Block\Customer\Wishlist\Item\Column;

class Category extends \Magento\Wishlist\Block\Customer\Wishlist\Item\Column 
{
    public function getCollection(){
        $b = $this->getLayout()->createBlock("\Demo\Mywishlist\Block\Customer\Wishlist\Item\Column\WishlistCategory");
        $collection = $b->getWishlistCategoryCollection();
        
        return $collection;
    }
    
    
}
