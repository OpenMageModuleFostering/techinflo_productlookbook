<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Model_Productlookbook extends Mage_Core_Model_Abstract
{
    const CACHE_TAG              = 'productlookbook_free';
    protected $_cacheTag         = 'productlookbook_free';
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('productlookbook/productlookbook');
    }

}
