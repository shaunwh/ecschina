<?php

class LilySoft_ImageShow_Model_Mysql4_ImageShow extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the imageshow_id refers to the key field in your database table.
        $this->_init('imageshow/imageshow', 'imageshow_id');
    }
}