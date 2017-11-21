<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerLogin
 *
 * @author HP
 */
namespace Store\PostCode\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomerLogin implements ObserverInterface
{
    
//    protected $_response;
//    
//
//    public function __construct(
//        \Magento\Framework\App\ResponseInterface $response
//    ) {
//        
//        $this->_response = $response;
//
//    }
    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
//        $customer = $observer->getEvent()->getCustomer();
//        $url = $customer->getUrl(); 
//        if($url != null){
//            die($url);
//            $observer->getControllerAction()
//                    ->getResponse()
//                    ->setRedirect("192.168.33.60");
////            echo $url;
////            $this->_response->setRedirect($url)->sendResponse();
////            exit(0);
//        }
//        
//        else{
//            exit;
//        }
        
    }
}
