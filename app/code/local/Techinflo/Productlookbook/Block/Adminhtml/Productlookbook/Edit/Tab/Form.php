<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();

      $this->setForm($form);

      $fieldset = $form->addFieldset('productlookbook_form', array('legend'=>Mage::helper('productlookbook')->__('Product Lookbook Slide Information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('productlookbook')->__('Name'),
          'required'  => true,
          'name'      => 'name',
      ));
 
      $fieldset->addField('position', 'text', array(
          'label'     => Mage::helper('productlookbook')->__('Order'),
          'required'  => false,
          'name'      => 'position',
      ));

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('productlookbook')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('productlookbook')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('productlookbook')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addType('productlookbookimage','Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit_Form_Element_Productlookbookimage');
      $fieldset->addField('image', 'productlookbookimage', array(
          'label'     => Mage::helper('productlookbook')->__('Image'),
          'name'      => 'image',
          'required'  => true,       
      ));
      
      $fieldset->addType('hotspots','Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit_Form_Element_Hotspots');
      $fieldset->addField('hotspots', 'hotspots', array(
          'name'      => 'hotspots',        
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getProductlookbookData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductlookbookData());
          Mage::getSingleton('adminhtml/session')->setProductlookbookData(null);
      } elseif ( Mage::registry('productlookbook_data') ) {
          $form->setValues(Mage::registry('productlookbook_data')->getData());
      }
      return parent::_prepareForm();
  }
}