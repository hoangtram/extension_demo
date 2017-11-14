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
class Form extends \Magento\Framework\View\Element\Template{
    protected $_storeManager;
    protected $_connection;    
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,        
        array $data = []
    )
    {    
        $this->_connection = $resource->getConnection();
        $this->_storeManager = $storeManager;        
        parent::__construct($context, $data);
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
        
        $sql = "SELECT scope_id FROM " . $tableName . " WHERE value = '" . $postCode . "' AND path = 'general/store_information/postcode' ORDER BY config_id DESC" ;
        $result = $connection->fetchAll($sql);
        
        $url = [];
        if($result != null){
            $scope_id = [];
            foreach ($result as $value) {
                $scope_id[] = $value["scope_id"];
            }
            $in = '(' . implode(',', $scope_id) .')';
            $sql = "SELECT value FROM " . $tableName . " WHERE scope_id IN " . $in . " AND path = 'web/unsecure/base_url' ORDER BY config_id DESC";        
            $result = $connection->fetchAll($sql);
            foreach ($result as $value) {
                $url[] = $value["value"];
            }
            
        }
        else{
            $scope_id = 0;
            $sql = "SELECT value FROM " . $tableName . " WHERE scope_id = " . $scope_id . " AND path = 'web/unsecure/base_url' ORDER BY config_id DESC";        
            $result = $connection->fetchAll($sql);
            $url[] = $result[0]["value"];
        }
        
        return $url;
        
    }
}
