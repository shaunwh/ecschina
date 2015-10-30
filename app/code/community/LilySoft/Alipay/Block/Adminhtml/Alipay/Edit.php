<?php

class LilySoft_Alipay_Block_Adminhtml_Alipay_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'alipay';
        $this->_controller = 'adminhtml_alipay';
        
        $this->_updateButton('save', 'label', Mage::helper('alipay')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('alipay')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('alipay_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'alipay_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'alipay_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('alipay_data') && Mage::registry('alipay_data')->getId() ) {
            return Mage::helper('alipay')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('alipay_data')->getTitle()));
        } else {
            return Mage::helper('alipay')->__('Add Item');
        }
    }
}