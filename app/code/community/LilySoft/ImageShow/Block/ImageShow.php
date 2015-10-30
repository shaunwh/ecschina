<?php
class LilySoft_ImageShow_Block_ImageShow extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getImageShow()     
     { 
        if (!$this->hasData('imageshow')) {
            $this->setData('imageshow', Mage::registry('imageshow'));
        }
        return $this->getData('imageshow');
        
    }
}