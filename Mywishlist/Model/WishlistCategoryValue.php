<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Demo\Mywishlist\Model;
/**
 * Description of WishlistCategory
 *
 * @author tram
 */
class WishlistCategoryValue extends \Magento\Framework\Model\AbstractModel{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Demo\Mywishlist\Model\ResourceModel\WishlistCategoryValue');
    }
}
