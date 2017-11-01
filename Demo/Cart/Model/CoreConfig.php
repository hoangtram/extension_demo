<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Demo\Cart\Model;

/**
 * Description of CoreConfig
 *
 * @author HP
 */
class CoreConfig extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Demo\Cart\Model\ResourceModel\CoreConfig');
    }

    //get Persistence Lifetime (seconds) in table core_config_data
    public function getSesstionCart()
    {
        $data = $this->getCollection()
            ->addFieldToFilter('path', ['eq' => 'persistent/options/lifetime'])
            ->getData();
        if ($data) {
            return $data[0]['value'];
        } else {
            return 0;
        }
    }
}
