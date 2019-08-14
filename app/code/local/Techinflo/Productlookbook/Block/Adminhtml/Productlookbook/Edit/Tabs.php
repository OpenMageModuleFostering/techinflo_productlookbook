<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productlookbook_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productlookbook')->__('Product Lookbook Slide Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productlookbook')->__('Product Lookbook Slide Information'),
          'title'     => Mage::helper('productlookbook')->__('Product Lookbook Slide Information'),
          'content'   => $this->getLayout()->createBlock('productlookbook/adminhtml_productlookbook_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}