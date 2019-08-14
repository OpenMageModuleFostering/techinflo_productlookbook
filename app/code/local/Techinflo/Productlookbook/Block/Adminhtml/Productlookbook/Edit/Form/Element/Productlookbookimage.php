<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Edit_Form_Element_Productlookbookimage extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('hidden');
    }

 public function getElementHtml()
 {
    $block_class =  Mage::getBlockSingleton('productlookbook/adminhtml_productlookbook');
    $upload_action  = Mage::getUrl('productlookbook/adminhtml_productlookbook/upload', array('_secure'=>true)).'?isAjax=true';
    $media_url  = Mage::getBaseUrl('media');
    $upload_folder_path = str_replace("/",DS, Mage::getBaseDir("media").DS);
    $helper = Mage::helper('productlookbook');
    $min_image_width = $helper->getMinImageWidth();
    $min_image_height = $helper->getMinImageHeight();
    $sizeLimit      = $helper->getMaxUploadFilesize();
    $allowed_extensions = implode('","',explode(',',$helper->getAllowedExtensions()));
    
    $html = '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function() { 
                    
                  InitHotspotBtn(); 
                  
                    img_uploader = new qq.FileUploader({
                        element: document.getElementById(\'maket_image\'),
                        action: "'.$upload_action.'",
                        params: {"form_key":"'.$block_class->getFormKey().'"},
                        multiple: false,
                        allowedExtensions: ["'.$allowed_extensions.'"],
                        sizeLimit: '. $sizeLimit .',
                        onComplete: function(id, fileName, responseJSON){                           
                                    if (responseJSON.success) 
                                    {
                                        if (jQuery(\'#ProductlookbookImageBlock\')) 
                                        {
                                          jQuery.each(jQuery(\'#ProductlookbookImageBlock\').children(),function(index) {
                                            jQuery(this).remove();
                                          });
                                        }
                                       jQuery(\'#ProductlookbookImageBlock\').append(\'<img id="ProductlookbookImage"';
                                       $html .= ' src="'.$media_url.'productlookbook/\'+responseJSON.filename+\'" alt="\'+responseJSON.filename+\'"'; 
                                       $html .= ' width="\'+responseJSON.dimensions.width+\'" height="\'+responseJSON.dimensions.height+\'"/>\');
                                       
                                        if (jQuery(\'#advice-required-entry-image\')) 
                                        {
                                            jQuery(\'#advice-required-entry-image\').remove();
                                        }
                                        jQuery(\'#ProductlookbookImage\').load(function(){
                                           jQuery(this).attr(\'width\',responseJSON.dimensions.width);
                                           jQuery(this).attr(\'height\',responseJSON.dimensions.height);
                                           InitHotspotBtn();
                                        });                       
                                        jQuery(\'#image\').val(\'productlookbook/\'+responseJSON.filename);
                                        jQuery(\'#image\').removeClass(\'validation-failed\');
                                    }

                        }
                    });    
                });
                //]]>
                </script>
                <div id="ProductlookbookImageBlock">';
                
        if ($this->getValue()) {
            $img_src = $media_url.$this->getValue();
            $img_path = $upload_folder_path.$this->getValue();
            if (file_exists($img_path)) {
                                
                $dimensions = Mage::helper('productlookbook')->getImageDimensions($img_path);
                
                $html .= '<img id="ProductlookbookImage" src="'.$img_src.'" alt="'.basename($img_src).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'"/>';
            }
            else
            {
                $html .= '<h4 id="ProductlookbookImage" style="color:red;">File '.$img_src.' doesn\'t exists.</h4>';
            }     
        }

        $html .= '</div>
                <div id="maket_image">       
                    <noscript>          
                        <p>Please enable JavaScript to use file uploader.</p>
                        <!-- or put a simple form for upload here -->
                    </noscript>         
                </div>';
                
        $html.= parent::getElementHtml();
        
        if ($min_image_width!=0 && $min_image_height!=0){
          $html.= '<p class="note" style="clear:both; float:left;">Please make sure that the image your load is at least '
                    .$min_image_width.'x'.$min_image_height.' pixels</p>';
        }
        
        return $html;
 }
}