<?php

class LilySoft_ImageShow_Block_Adminhtml_ImageShow_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('imageshow_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('imageshow')->__('Image Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('imageshow')->__('Image Information'),
          'title'     => Mage::helper('imageshow')->__('Image Information'),
          'content'   => $this->getLayout()->createBlock('imageshow/adminhtml_imageshow_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}