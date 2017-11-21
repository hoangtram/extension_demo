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


class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
            $this->_pageFactory = $pageFactory;
            return parent::__construct($context);
    }
    public function execute()
    {

        return $this->_pageFactory->create();
    }
}
