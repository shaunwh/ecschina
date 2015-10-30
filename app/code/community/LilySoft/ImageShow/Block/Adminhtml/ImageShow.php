<?php
class LilySoft_ImageShow_Block_Adminhtml_ImageShow extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_imageshow';
    $this->_blockGroup = 'imageshow';
    $this->_headerText = Mage::helper('imageshow')->__('Image Manager');
    $this->_addButtonLabel = Mage::helper('imageshow')->__('Add Image');
    parent::__construct();
  }
}