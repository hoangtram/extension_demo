<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Store\PostCode\Model\ResourceModel;
/**
 * Description of customer
 *
 * @author HP
 */
class Customer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct()
    {
        
        $this->_init('customer_entity', 'entity_id');
    }
}
