<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Store\PostCode\Block;
/**
 * Description of Form
 *
 * @author HP
 */
class Form extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface{
    protected $_template = "form_info.phtml";
    protected $customerSession;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context
    )
    {      
        parent::__construct($context);
    }
    
//    public function getStoreId()
//    {
//        return $this->_storeManager->getStore()->getId();
//    }
    
    public function getStoreUrl($postCode){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('core_config_data');
        $tableStore = $resource->getTableName('store');
        
        $sql = "SELECT scope_id FROM " . $tableName . " WHERE value = '" . $postCode . "' AND path = 'general/store_information/postcode' " ;
        $result1 = $connection->fetchAll($sql);
        
        $url = [];
        if($result1 != null){
            $scope_id = [];
            foreach ($result1 as $value) {
                $scope_id[] = $value["scope_id"];
            }
            $in = '(' . implode(',', $scope_id) .')';
            
            $sql = "SELECT store_id, code FROM " . $tableStore . " WHERE store_id <> 1 AND website_id IN " . $in ;        
            $result2 = $connection->fetchAll($sql);
            $store_id = [];
            $code = [];
            foreach ($result2 as $key => $value) {
                $store_id[] = $value["store_id"];
                $code[] = $value["code"];
            }
            
            $in = '(' . implode(',', $store_id) .')';
            
            $sql = "SELECT value FROM " . $tableName . " WHERE scope ='stores' AND scope_id IN " . $in . " AND path = 'web/unsecure/base_url' ";        
            $result3 = $connection->fetchAll($sql);
            
            foreach ($result3 as $key => $value) {

                $url[$key] = $value["value"].$code[$key];
            }
           
        }
        else{
            $scope_id = 0;
            $sql = "SELECT value FROM " . $tableName . " WHERE scope_id = " . $scope_id . " AND path = 'web/unsecure/base_url' ";        
            $result = $connection->fetchAll($sql);
            $url[] = $result[0]["value"]."default";
        }
        
        
        return $url;
        
    }
    
    
    public function checkCookie(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cookieManager = $objectManager->get('Magento\Framework\Stdlib\CookieManagerInterface');
        $value = $cookieManager->getCookie('path');
        if($value == null){
            return false;
        }else{
            return true;
        }
    }
}
