<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Mywishlist\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
/**
 * Description of Add
 *
 * @author tram
 */
class Add extends \Magento\Framework\App\Action\Action{
    
    protected $customerSession;
    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * Execute view action
     * 
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $customer_id = $this->customerSession->getCustomerId();
//        die($customer_id);
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if($this->getRequest()->getParam("wishlist_category_id") != null){
            $wishlist_category_id = $this->getRequest()->getParam("wishlist_category_id");
            $resultRedirect->setPath('demowishlist/index/index/', ['wishlist_category_id' => $wishlist_category_id]);
            return $resultRedirect;
        }else{
            $request = $this->getRequest()->getParams();           
            $new_category = $request['wishlist_category_text'];
            $description = $request['wishlist_category_description'];
            $wishlist_category = $this->_objectManager->create('Demo\Mywishlist\Model\WishlistCategory');
            
            $wishlist_category->setLabel($new_category);
            $wishlist_category->setDescription($description);
            $wishlist_category->setCustomerId($customer_id);
            $wishlist_category->save();
        }
        

        
        $resultRedirect->setPath('demowishlist/index/index');
        return $resultRedirect;
    }
    
}
