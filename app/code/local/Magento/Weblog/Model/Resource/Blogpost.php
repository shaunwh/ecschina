<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-9-15
 * Time: 上午10:15
 */
class Magento_Weblog_Model_Resource_Blogpost extends Mage_Core_Model_Resource_Db_Abstract{

    protected function _construct(){
        $this->_init('weblog/blogpost','category_id');
    }
}