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
    
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
    
    public function getStoreUrl(){
        $$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('core_config_data');
        
        $sql = "Select * FROM " . $tableName . " where scope = 'stores' and scope_id in " ;
        $result = $connection->fetchAll($sql);
        
    }
}
