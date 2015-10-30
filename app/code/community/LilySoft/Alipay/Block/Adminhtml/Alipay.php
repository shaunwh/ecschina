<?php
class LilySoft_Alipay_Block_Adminhtml_Alipay extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_alipay';
    $this->_blockGroup = 'alipay';
    $this->_headerText = Mage::helper('alipay')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('alipay')->__('Add Item');
    parent::__construct();
  }
}