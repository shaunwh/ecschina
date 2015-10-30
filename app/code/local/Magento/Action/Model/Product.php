<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-9-14
 * Time: 下午2:17
 */

class Magento_Action_Model_Product extends Mage_Core_Model_Abstract{

    protected function _construct(){

        $this->_init('action/catalog_product_entity');
    }
}