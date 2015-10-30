<?php
class LilySoft_Alipay_Block_Alipay extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAlipay()     
     { 
        if (!$this->hasData('alipay')) {
            $this->setData('alipay', Mage::registry('alipay'));
        }
        return $this->getData('alipay');
        
    }
}