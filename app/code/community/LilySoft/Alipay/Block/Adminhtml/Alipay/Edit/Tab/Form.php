<?php

class LilySoft_Alipay_Block_Adminhtml_Alipay_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('alipay_form', array('legend'=>Mage::helper('alipay')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('alipay')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('alipay')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('alipay')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('alipay')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('alipay')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('alipay')->__('Content'),
          'title'     => Mage::helper('alipay')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getAlipayData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAlipayData());
          Mage::getSingleton('adminhtml/session')->setAlipayData(null);
      } elseif ( Mage::registry('alipay_data') ) {
          $form->setValues(Mage::registry('alipay_data')->getData());
      }
      return parent::_prepareForm();
  }
}