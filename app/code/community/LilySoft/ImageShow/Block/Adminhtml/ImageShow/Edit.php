<?php

class LilySoft_ImageShow_Block_Adminhtml_ImageShow_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'imageshow';
        $this->_controller = 'adminhtml_imageshow';
        
        $this->_updateButton('save', 'label', Mage::helper('imageshow')->__('Save Image'));
        $this->_updateButton('delete', 'label', Mage::helper('imageshow')->__('Delete Image'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('imageshow_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'imageshow_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'imageshow_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('imageshow_data') && Mage::registry('imageshow_data')->getId() ) {
            return Mage::helper('imageshow')->__("Edit Image '%s'", $this->htmlEscape(Mage::registry('imageshow_data')->getTitle()));
        } else {
            return Mage::helper('imageshow')->__('Add Image');
        }
    }
}