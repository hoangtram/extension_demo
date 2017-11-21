<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Store\PostCode\Controller\Index;

/**
 * Description of SaveCookie
 *
 * @author HP
 */
class Savecookie extends \Magento\Framework\App\Action\Action {
    const JOB_COOKIE_NAME = 'path';
    const JOB_COOKIE_DURATION = 2592000;
    
    protected $_cookieManager;
    protected $_cookieMetadataFactory;
    protected $request;
    protected  $_resource;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\ResourceConnection $resource) 
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        $this->customerSession = $customerSession;
        $this->request = $request;
        $this->_resource = $resource;
        parent::__construct($context);
    }
    public function execute() {
        
        $result = $this->resultJsonFactory->create();
        $metadata = $this->_cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setDuration(self::JOB_COOKIE_DURATION)
            ->setPath("/");
            
        if ($this->request->getParam('url') != null) {
            $url = $this->request->getParam('url');
            $path = str_replace("http://192.168.33.60/","",$url);
            
            
            $this->_cookieManager->setPublicCookie(
                self::JOB_COOKIE_NAME,
                $path,
                $metadata
            );
            
//            if($this->customerSession->getCustomer() != null){
//                $connection = $this->_resource->getConnection('Magento\Framework\App\ResourceConnection');
//                $tableName = $connection->getTableName('customer_entity');
//                $cus_id = $this->customerSession->getCustomer()->getId();
//                $connection->update($tableName, ['postcode' => $url], ['entity_id = ?' => $cus_id]);
//            }
        
        }

        return $result->setData("OK");
        
    }
}
