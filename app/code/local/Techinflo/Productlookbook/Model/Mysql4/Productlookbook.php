<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Model_Mysql4_Productlookbook extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productlookbook_id refers to the key field in your database table.
        $this->_init('productlookbook/productlookbook', 'productlookbook_id');
    }
}