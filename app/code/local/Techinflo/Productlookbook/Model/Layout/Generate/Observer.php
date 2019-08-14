<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Model_Layout_Generate_Observer {

	public function addHeadItems($observer) {
            if (Mage::helper('productlookbook')->getEnabled()) {
            	$data = $observer->getData(); 
                $page = $data['page'];
                if ($page) {
                    $pagecontent = 	$page->getContent();       
                    $search_string = '{{block type="productlookbook/productlookbook" template="productlookbook/productlookbook.phtml"}}';
                    if (preg_match($search_string, $pagecontent)) {
                        $updates = $page->getLayoutUpdateXml();
                    	$newupdates = '<reference name="head">
                            	<action method="addCss"><stylesheet>productlookbook/css/hotspots.css</stylesheet></action>
                            	<action method="addJs"><script>jquery/jquery-1.8.2.min.js</script></action>
            		    	<action method="addJs"><script>productlookbook/jquery.mobile.customized.min.js</script></action>
				<action method="addJs"><script>jquery/jquery.noconflict.js</script></action>                 
        			<action method="addItem"><type>skin_js</type><name>productlookbook/js/jquery.easing.1.3.js</name></action>
                        	<action method="addItem"><type>skin_js</type><name>productlookbook/js/camera.min.js</name></action>
                        	<action method="addItem"><type>skin_js</type><name>productlookbook/js/hotspots.js</name></action>
                        </reference>';
                        $page->setLayoutUpdateXml($updates.$newupdates);
                    } 
                       
                } 
            }                               
	}

}