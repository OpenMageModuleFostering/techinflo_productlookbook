<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getEnabled()
	{
		return Mage::getStoreConfig('productlookbook/general/enabled');
	}
    
    public function getMaxImageWidth()
	{
		return intval(Mage::getStoreConfig('productlookbook/general/max_image_width'));
	}

    public function getMaxImageHeight()
	{
		return intval(Mage::getStoreConfig('productlookbook/general/max_image_height'));
	}

    public function getMinImageWidth()
	{
		return intval(Mage::getStoreConfig('productlookbook/general/min_image_width'));
	}

    public function getMinImageHeight()
	{
		return intval(Mage::getStoreConfig('productlookbook/general/min_image_height'));
	}
 
    public function getMaxUploadFilesize()
	{
		return intval(Mage::getStoreConfig('productlookbook/general/max_upload_filesize'));
	}
  
    public function getAllowedExtensions()
	{
		return Mage::getStoreConfig('productlookbook/general/allowed_extensions');
	} 

    public function getEffects()
	{
		return Mage::getStoreConfig('productlookbook/general/effects');
	}
    public function getNavigation()
	{
		return Mage::getStoreConfig('productlookbook/general/navigation');
	}   
    public function getNavigationHover()
	{
		return Mage::getStoreConfig('productlookbook/general/navigation_hover');
	}
    public function getThumbnails()
	{
		return Mage::getStoreConfig('productlookbook/general/thumbnails');
	} 
    public function getPause()
	{
		return Mage::getStoreConfig('productlookbook/general/pause');
	} 
    public function getTransitionDuration()
	{
		return Mage::getStoreConfig('productlookbook/general/transition_duration');
	}  
	
	/**
	* Returns the resized Image URL
	*
	* @param string $imgUrl - This is relative to the the media folder (custom/module/images/example.jpg)
	* @param int $x Width
	* @param int $y Height
	*Remember your base image or big image must be in Root/media/productlookbook/example.jpg
	*
	* echo Mage::helper('productlookbook')->getResizedUrl("productlookbook/example.jpg",101,65)
	*
	*By doing this new image will be created in Root/media/productlookbook/101X65/example.jpg
	*/

    public function getResizedUrl($imgUrl,$x,$y=NULL){

        $imgPath=$this->splitImageValue($imgUrl,"path");
        $imgName=$this->splitImageValue($imgUrl,"name");
 
        /**
         * Path with Directory Seperator
         */
        $imgPath=str_replace("/",DS,$imgPath);
 
        /**
         * Absolute full path of Image
         */
        $imgPathFull=Mage::getBaseDir("media").DS.$imgPath.DS.$imgName;
 
        /**
         * If Y is not set set it to as X
         */
        $width=$x;
        $y?$height=$y:$height=$x;
 
        /**
         * Resize folder is widthXheight
         */
        $resizeFolder=$width."X".$height;
 
        /**
         * Image resized path will then be
         */
        $imageResizedPath=Mage::getBaseDir("media").DS.$imgPath.DS.$resizeFolder.DS.$imgName;
 
        /**
         * First check in cache i.e image resized path
         * If not in cache then create image of the width=X and height = Y
         */
        if (!file_exists($imageResizedPath) && file_exists($imgPathFull)) :
            $imageObj = new Varien_Image($imgPathFull);
            $imageObj->constrainOnly(TRUE);
            $imageObj->keepAspectRatio(TRUE);
            $imageObj->keepTransparency(TRUE);
            $imageObj->resize($width,$height);
            $imageObj->save($imageResizedPath);
        endif;
 
        /**
         * Else image is in cache replace the Image Path with / for http path.
         */
        $imgUrl=str_replace(DS,"/",$imgPath);
 
        /**
         * Return full http path of the image
         */
        return Mage::getBaseUrl("media").$imgUrl."/".$resizeFolder."/".$imgName;
    }
 
    /**
     * Splits images Path and Name
     *
     * Path=productlookbook/
     * Name=example.jpg
     *
     * @param string $imageValue
     * @param string $attr
     * @return string
     */
    public function splitImageValue($imageValue,$attr="name"){
        $imArray=explode("/",$imageValue);
 
        $name=$imArray[count($imArray)-1];
        $path=implode("/",array_diff($imArray,array($name)));
        if($attr=="path"){
            return $path;
        }
        else
            return $name;
 
    }
    
     /**
     * Splits images Path and Name
     *
     * img_path=productlookbook/example.jpg
     *
     * @param string $img_path
     * @return array('width'=>$width, 'height'=>$height)
     */ 
    public function getImageDimensions($img_path){
            $imageObj = new Varien_Image($img_path);
            $width = $imageObj->getOriginalWidth();
            $height = $imageObj->getOriginalHeight();
            $result = array('width'=>$width, 'height'=>$height);
        return $result;
    }

	 /**
     * Change SKU to product information into Json array
     *
     * img_path=productlookbook/example.jpg
     *
     * @param json array $array
     * @return json array('width'=>$width, 'height'=>$height)
     */ 
    public function getHotspotsWithProductDetails($hotspots_json){
        if ($hotspots_json=='') return '';
		$decoded_array = json_decode($hotspots_json,true);
        $img_width = intval(Mage::getStoreConfig('productlookbook/general/max_image_width'));
		
              $selecticon= Mage::getStoreConfig('productlookbook/general/hotspot_iconselect');
					if($selecticon==1)
					{
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
        $hotspot_icon_path  = Mage::getBaseDir('media').DS.'productlookbook'.DS.'icons'.DS.'default'.DS.'hotspot-icon.png';
		$icon_dimensions = $this->getImageDimensions($hotspot_icon_path);
        $_coreHelper = Mage::helper('core');
        foreach($decoded_array as $key => $value){
		      $product_details = Mage::getModel('catalog/product')->loadByAttribute('sku',$decoded_array[$key]['text']);

            		$html_content = '<img class="hotspot-icon" src="'.$hotspot_icon.'" alt="" style="
                    left:'. (round($value['width']/2)-round($icon_dimensions['width']/2)) .'px; 
                    top:'. (round($value['height']/2)-round($icon_dimensions['height']/2)) .'px;width:30px;height:30px;
                    "/><div class="product-info" style="';           
                    $html_content .=  'left:'.round($value['width']/2).'px;';
                    $html_content .=  'top:'.round($value['height']/2).'px;';
                   
                if ($product_details) {
                    $_p_name = $product_details->getName();
                    $html_content .=  'width: '. strlen($_p_name)*8 .'px;';
                }
                else
                {
                    $html_content .=  'width: 200px;';
                }
                
                    $html_content .=  '">';
                if ($product_details) {
        			$_p_price = $_coreHelper->currency($product_details->getFinalPrice(),true,false);
                    if($product_details->isAvailable())
                    {
                        $_p_url = $product_details->getProductUrl();                                                                                    
            			$html_content .= '<div><a href=\''.$_p_url.'\'>'.$_p_name.'</a></div>';
                    }
                    else
                    {
                        $html_content .= '<div>'.$_p_name.'</div>';
                        $html_content .= '<div class="out-of-stock"><span>'. $this->__('Out of stock') .'</span></div>';                        
                    }

                    if($product_details->getFinalPrice()){
                            if ($product_details->getPrice()>$product_details->getFinalPrice()){
                                    $regular_price = $_coreHelper->currency($product_details->getPrice(),true,false);
                                    $_p_price = '<div class="old-price">'.$regular_price.'</div>'.$_p_price;
                            }
            				$html_content .= '<div class="price">'.$_p_price.'</div>';
            		}  
                }
                else
                {
                    $html_content .= '<div>Product with SKU "'.$decoded_array[$key]['text'].'" doesn\'t exists.</div>';
                }
			$html_content .= '	
			</div>
			';
			
			$decoded_array[$key]['text'] = $html_content;
		}
        $result = $decoded_array;
        return $result;
    }
}
