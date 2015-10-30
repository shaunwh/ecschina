<?php

class LilySoft_ImageShow_Model_ImageShow extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('imageshow/imageshow');
    }
}