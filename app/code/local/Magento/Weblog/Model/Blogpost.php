<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-9-14
 * Time: 下午5:51
 */
class Magento_Weblog_Model_Blogpost extends Mage_Core_Model_Abstract{
    protected function _construct(){
        $this->_init('weblog/blogpost');
    }
}