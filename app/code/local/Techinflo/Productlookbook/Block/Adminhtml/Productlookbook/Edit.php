<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productlookbook';
        $this->_controller = 'adminhtml_productlookbook';
        
        $this->_updateButton('save', 'label', Mage::helper('productlookbook')->__('Save slide'));
        $this->_updateButton('delete', 'label', Mage::helper('productlookbook')->__('Delete slide'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
                
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productlookbook_data') && Mage::registry('productlookbook_data')->getId() ) {
            return Mage::helper('productlookbook')->__("Edit slide '%s'", $this->htmlEscape(Mage::registry('productlookbook_data')->getName()));
        } else {
            return Mage::helper('productlookbook')->__('Add slide');
        }
    }
}