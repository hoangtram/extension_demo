<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Store\PostCode\Model\ResourceModel\Customer;
/**
 * Description of Collection
 *
 * @author HP
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
       
        $this->_init('Store\PostCode\Model\Customer', 'Store\PostCode\Model\ResourceModel\Customer');
    }

}
