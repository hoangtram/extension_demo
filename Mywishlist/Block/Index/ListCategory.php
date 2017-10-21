<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Mywishlist\Block\Index;

/**
 * Description of Adding
 *
 * @author tram
 */
class ListCategory extends \Magento\Framework\View\Element\Template{
    protected $customerSession;
    protected $categoryFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Demo\Mywishlist\Model\WishlistCategoryFactory $categoryFactory,
        array $data = []
    )
    {
        $this->customerSession = $customerSession;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $data);

    }

    public function getWishlistCategory(){
        return $this->categoryFactory->create()->getCollection()
            ->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
    }
}
