<?php

class LilySoft_Alipay_Block_Adminhtml_Alipay_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('alipay_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('alipay')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('alipay')->__('Item Information'),
          'title'     => Mage::helper('alipay')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('alipay/adminhtml_alipay_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}