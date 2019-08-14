<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit_Form_Element_Hotspots extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('hidden');
    }

    public function getElementHtml()
    {
	 $selecticon= Mage::getStoreConfig('productlookbook/general/hotspot_iconselect');
    if($selecticon==1)
	{
     $siteurl=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
	$dir = 'media/productlookbook/icons/default/';
      $base_url =  Mage::getBaseUrl('media').'productlookbook/icons/default/';
     $newest_mtime = 0;
      $show_file = 'BROKEN';
     if ($handle = opendir($dir)) {
     while (false !== ($file = readdir($handle))) {
     if (($file != '.') && ($file != '..')) {
       $mtime = filemtime("$dir/$file");
        if ($mtime > $newest_mtime) {
          $newest_mtime = $mtime;
          $hotspot_icon = "$base_url/$file";
          }
           }
            }
             }
		}
		else{
		$hotspot_icon  = Mage::getBaseUrl('media').'productlookbook/icons/default/hotspot-icon.png';	
		}

        $products_link = Mage::helper("adminhtml")->getUrl('adminhtml/catalog_product/');
        $helper = Mage::helper('productlookbook');
    
        $html = '
        <style>
            .image-annotate-area, .image-annotate-edit-area {
			     background-size:30px 30px;
                background: url('.$hotspot_icon.') no-repeat center center;
            }                                                              
        </style>
                <script type="text/javascript">
                //<![CDATA[                    
                        function InitHotspotBtn() {
                             if (jQuery("img#ProductlookbookImage").attr("id")) {
                				var annotObj = jQuery("img#ProductlookbookImage").annotateImage({                				    
                					editable: true,
                					useAjax: false,';
   if ($this->getValue()) $html .= 'notes: '. $this->getValue() . ',';
   
       $html .= '                   input_field_id: "hotspots"                            
                				});
                                
                                jQuery("img#ProductlookbookImage").before(\'<div class="products-link"><a href="'.$products_link.'" title="'.$helper->__('Products List').'" target="_blank">'. $helper->__('Products List').'</a></div>\');
                                
                                var top = Math.round(jQuery("img#ProductlookbookImage").height()/2);
                                jQuery(".image-annotate-canvas").append(\'<div class="hotspots-msg" style="top:\' + top + \'px;">'. $helper->__('Rollover on the image to see hotspots').'</div>\');
                        
                                jQuery(".image-annotate-canvas").hover(
                                      function () {
                                            ShowHideHotspotsMsg();
                                      },
                                      function () {
                                            ShowHideHotspotsMsg();
                                      }
                                    );
                                    
                                return annotObj;
                            }
                            else
                            {
                                return false;
                            }
                        };        
                                                
                        function checkSKU(){
                                    result = "";
                                    request = new Ajax.Request(
                                    "'. Mage::getUrl("productlookbook/adminhtml_productlookbook/getproduct", array('_secure'=>true)).'",
                                    {
                                        method: \'post\',
                                        asynchronous: false,
                                        onComplete: function(transport){
                                            if (200 == transport.status) {
                                                result = transport.responseText;
                                                return result;
                                            }
                                            if (result.error) {
                                                alert("Unable to check product SKU");
                                                return false;                                                                                                
                                            }
                                        },
                                        parameters: Form.serialize($("annotate-edit-form"))
                                    }
                                );
                                return result;
                        };
                //]]>
                </script>';

        $html.= parent::getElementHtml();

        return $html;
    }
}
               
  
 