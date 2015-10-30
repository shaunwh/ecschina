<?php

class LilySoft_ImageShow_Block_Adminhtml_ImageShow_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('imageshow_form', array('legend'=>Mage::helper('imageshow')->__('Image information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('imageshow')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('imageshow')->__('Image'),
      	  'class'     => 'required-entry',
      	  'required'  => true,
          'name'      => 'filename111',
      	 
	  ));
	  
	  $fieldset->addField('href', 'text', array(
          'label'     => Mage::helper('imageshow')->__('Href'),
          'required'  => false,
          'name'      => 'href',
	  ));
	  $fieldset->addField('sortorder', 'text', array(
          'label'     => Mage::helper('imageshow')->__('Sort Order'),
          'name'      => 'sortorder',
	      'class' => 'validate-number',
	  	  'value'     => 0,
	  ));
	  
	 
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('imageshow')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('imageshow')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('imageshow')->__('Disabled'),
              ),
          ),
          'selected'=>2
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('imageshow')->__('Content'),
          'title'     => Mage::helper('imageshow')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getImageShowData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getImageShowData());
          Mage::getSingleton('adminhtml/session')->setImageShowData(null);
      } elseif ( Mage::registry('imageshow_data') ) {
          $form->setValues(Mage::registry('imageshow_data')->getData());
      }
      return parent::_prepareForm();
  }
  //替换掉原来的 image类型，然后使用这个进行重写，看行不行
	protected function _getAdditionalElementTypes()
    {
        return array(
            'image' => Mage::getConfig()->getBlockClassName('imageshow/helper_image')
        );
    }
}