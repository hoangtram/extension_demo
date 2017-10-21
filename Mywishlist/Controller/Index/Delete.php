<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Mywishlist\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
/**
 * Description of Delete
 *
 * @author tram
 */
class Delete extends \Magento\Framework\App\Action\Action{
    
    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context
    )
    {
        
        parent::__construct($context);
    }

    /**
     * Execute view action
     * 
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        
        $wishlist_category_id = $this->getRequest()->getParam("wishlist_category_id");
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('demo_mywishlist_category');
        
        $sql = "DELETE FROM " . $tableName . " WHERE wishlist_category_id = " . $wishlist_category_id;
        $connection->query($sql);
        
        
        $resultRedirect->setPath('demowishlist/index/index');
        return $resultRedirect;
    }
}
