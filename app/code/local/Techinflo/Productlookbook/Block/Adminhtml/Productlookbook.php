<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_productlookbook';
    $this->_blockGroup = 'productlookbook';
    $this->_headerText = Mage::helper('productlookbook')->__('Product Lookbook Slide Manager');
    $this->_addButtonLabel = Mage::helper('productlookbook')->__('Add Product Slide');
    parent::__construct();
  }
}