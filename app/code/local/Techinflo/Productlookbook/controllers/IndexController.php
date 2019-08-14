<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {	 
        if (Mage::helper('productlookbook')->getEnabled()) {
 		     $this->loadLayout();     
		  $this->renderLayout();              
        }
        else
        {
           $this->_forward('*/*/noRouteAction');
        }

    }
    
    public function noRouteAction($coreRoute = null)
    {
        //modify this method as you need	
        $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
        $this->getResponse()->setHeader('Status','404 File not found');
        $pageId = Mage::getStoreConfig('web/default/cms_no_route');
        if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
            $this->_forward('defaultNoRoute');
       }
    }
    
}