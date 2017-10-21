<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Mywishlist\Controller\Index;

use Magento\Framework\App\Action;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Wishlist\Model\LocaleQuantityProcessor;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use Magento\Framework\Data\Form\FormKey\Validator;

class Update extends \Magento\Wishlist\Controller\AbstractIndex
{
    protected $wishlistProvider;
    protected $quantityProcessor;
    protected $_formKeyValidator;
    
    public function __construct(
        Action\Context $context,
        Validator $formKeyValidator,
        WishlistProviderInterface $wishlistProvider,
        LocaleQuantityProcessor $quantityProcessor
    ) {
        $this->_formKeyValidator = $formKeyValidator;
        $this->wishlistProvider = $wishlistProvider;
        $this->quantityProcessor = $quantityProcessor;
        parent::__construct($context);
    }

    public function execute()
    {
//        die("mm");
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            $resultRedirect->setPath('wishlist/');
            return $resultRedirect;
        }
        $wishlist = $this->wishlistProvider->getWishlist();
        if (!$wishlist) {
            throw new NotFoundException(__('Page not found.'));
        }

        $post = $this->getRequest()->getPostValue();
        if ($post && isset($post['description']) && is_array($post['description'])) {
            $updatedItems = 0;

            foreach ($post['description'] as $itemId => $description) {
                $item = $this->_objectManager->create('Magento\Wishlist\Model\Item')->load($itemId);
                if ($item->getWishlistId() != $wishlist->getId()) {
                    continue;
                }

                // Extract new values
                $description = (string)$description;

                if ($description == $this->_objectManager->get('Magento\Wishlist\Helper\Data')->defaultCommentString()
                ) {
                    $description = '';
                } elseif (!strlen($description)) {
                    $description = $item->getDescription();
                }

                $qty = null;
                if (isset($post['qty'][$itemId])) {
                    $qty = $this->quantityProcessor->process($post['qty'][$itemId]);
                }
                if ($qty === null) {
                    $qty = $item->getQty();
                    if (!$qty) {
                        $qty = 1;
                    }
                } elseif (0 == $qty) {
                    try {
                        $item->delete();
                    } catch (\Exception $e) {
                        $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                        $this->messageManager->addError(__('We can\'t delete item from Wish List right now.'));
                    }
                }

                //update wishlist category 
                
                 
                
                $wishlist_category_id = null;
                if(isset($post['wishlistcategory'][$itemId])){
                    
                    $wishlist_category_id = $post['wishlistcategory'][$itemId];
                    if($wishlist_category_id > 0){
                        $wishlist_category_value = $this->_objectManager->create('Demo\Mywishlist\Model\WishlistCategoryValue');
                        
                        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                        $connection = $resource->getConnection();
                        $tableName = $resource->getTableName('demo_mywishlist_category_value');
                        $sql = "Select * FROM " . $tableName." WHERE wishlist_item_id = ".$itemId;
                        $result = $connection->fetchAll($sql);
                        if($result != null){
                            foreach ($result as $value) {
                                $id =  $value['wishlist_category_value_id'];
                                $sql = "Update " . $tableName . " Set wishlist_category_id = ".$wishlist_category_id." where wishlist_category_value_id = ".$id;
                                $connection->query($sql);
                            }
                            
                        }else{
                            $wishlist_category_value->setWishlistItemId($itemId);
                            $wishlist_category_value->setWishlistCategoryId($wishlist_category_id);
                            $wishlist_category_value->save();
                        }
                        
                    }
                    
                }
                
                
                // Check that we need to save
                if ($item->getDescription() == $description && $item->getQty() == $qty) {
                    continue;
                }
                try {
                    $item->setDescription($description)->setQty($qty)->save();
                    $updatedItems++;
                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __(
                            'Can\'t save description %1',
                            $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($description)
                        )
                    );
                }
            }

            // save wishlist model for setting date of last update
            if ($updatedItems) {
                try {
                    $wishlist->save();
                    $this->_objectManager->get('Magento\Wishlist\Helper\Data')->calculate();
                } catch (\Exception $e) {
                    $this->messageManager->addError(__('Can\'t update wish list'));
                }
            }

            if (isset($post['save_and_share'])) {
                $resultRedirect->setPath('wishlist/index/share', ['wishlist_id' => $wishlist->getId()]);
                
                return $resultRedirect;
            }
        }
        $resultRedirect->setPath('wishlist/', ['wishlist_id' => $wishlist->getId()]);
        
        return $resultRedirect;
    }
}
