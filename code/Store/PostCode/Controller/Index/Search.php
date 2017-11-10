<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Store\PostCode\Controller\Index;

/**
 * Description of Search
 *
 * @author HP
 */
class Search extends \Magento\Framework\App\Action\Action {
    protected $request;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory) 
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        parent::__construct($context);
    }
    public function execute() {
        $result = $this->resultJsonFactory->create();
        $layout = $this->_view->getLayout();
        $block = $layout->createBlock('Store\PostCode\Block\Form');
        if ($this->request->getParam('zip') != null) 
        {
            //echo "yes";
            $zip_code = $this->request->getParam('zip');
            
            $url = $block->getStoreUrl($zip_code);
            return $result->setData($url);
        }
        else{
            //echo "no";
            return $result->setData("error");
        }
        

    }
}
