<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Demo\Mywishlist\Model\ResourceModel\WishlistCategoryValue;
/**
 * Description of Collection
 *
 * @author tram
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected function _construct()
    {
        $this->_init('Demo\Mywishlist\Model\WishlistCategoryValue', 'Demo\Mywishlist\Model\ResourceModel\WishlistCategoryValue');
    }
}
