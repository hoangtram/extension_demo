<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Demo\Mywishlist\Model\ResourceModel;
/**
 * Description of WishlistCategory
 *
 * @author tram
 */
class WishlistCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct()
    {
        $this->_init('demo_mywishlist_category', 'wishlist_category_id');
    }
}
