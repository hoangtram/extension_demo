<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Store\PostCode\Model;
/**
 * Description of customer
 *
 * @author HP
 */
class Customer extends \Magento\Framework\Model\AbstractModel{
    protected function _construct()
    {
        $this->_init('Store\PostCode\Model\ResourceModel\Customer');
    }
    
    
    public function savePostCode($postcode){
        
    }
}
