<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Productlookbook extends Mage_Core_Block_Template
{    
    protected function _construct()
    {
        $this->addData(array(
        'cache_lifetime' => false,
        'cache_tags'     => array(Techinflo_Productlookbook_Model_Productlookbook::CACHE_TAG),
        'cache_key'      => 'slider',
        ));
    }

	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

    public function getCollection()
    {
        $collection = Mage::getModel('productlookbook/productlookbook')
                        ->getCollection()
                        ->addFieldToFilter('status', 1)
                        ->setOrder('position', 'ASC');
        return $collection;
    }
    
}