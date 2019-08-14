<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Adminhtml_ProductlookbookController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('cms')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Lookbook Slide Manager'), Mage::helper('adminhtml')->__('Product Lookbook Slide Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
        $slides_count = Mage::getModel('productlookbook/productlookbook')->getCollection()
                        ->getSize();
        $id     = $this->getRequest()->getParam('id');
        if ($slides_count<10 || $id) {                

    		$model  = Mage::getModel('productlookbook/productlookbook')->load($id);
    
    		if ($model->getId() || $id == 0) {
    			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    			if (!empty($data)) {
    				$model->setData($data);
    			}
    
    			Mage::register('productlookbook_data', $model);
    
    			$this->loadLayout();
    			$this->_setActiveMenu('cms');
    
    			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Lookbook Slide Manager'), Mage::helper('adminhtml')->__('Product Lookbook Slide Manager'));
    
    			$this->_addContent($this->getLayout()->createBlock('productlookbook/adminhtml_productlookbook_edit'))
    				->_addLeft($this->getLayout()->createBlock('productlookbook/adminhtml_productlookbook_edit_tabs'));
    
    			$this->renderLayout();
    		} else {
    			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productlookbook')->__('Slide does not exist'));
    			$this->_redirect('*/*/');
    		}
      }
      else
      {
         Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productlookbook')->__('Only up to 10 slides could be uploaded in Product Lookbook extension.'));
    	 $this->_redirect('*/*/');
      }
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {	
	  			
			$model = Mage::getModel('productlookbook/productlookbook');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
			 
                 if ($model->getId() && isset($data['identifier_create_redirect']))
                 {
                        $model->setData('save_rewrites_history', (bool)$data['identifier_create_redirect']);
                 }
             
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productlookbook')->__('Slide was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productlookbook')->__('Unable to find slide to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('productlookbook/productlookbook');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Slide was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function uploadAction()
	{

           $upload_dir  = Mage::getBaseDir('media').'/productlookbook/';
           if (!file_exists($upload_dir)) mkdir($upload_dir, 0755, true);
            
            $uploader = Mage::getModel('productlookbook/fileuploader');

            $config_check = $uploader->checkServerSettings();

            if ($config_check === true){
               $result = $uploader->handleUpload($upload_dir); 
            } 
            else
            {
                $result = $config_check;
            }

            // to pass data through iframe you will need to encode all html tags
            $this->getResponse()->setBody(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
	}

    
    public function getproductAction(){
        	$sku     = $this->getRequest()->getParam('text');
            $product_id = Mage::getModel('catalog/product')->getIdBySku($sku);
            $status =  Mage::getModel('catalog/product')->load($product_id)->getStatus();
            if ($product_id) {
                if ($status==1) 
                {
                  $result= 1;  
                }
                else
                {
                  $result = "is disabled";  
                }
                
            }
            else
            {
                $result = "doesn't exists"; 
            }
    $this->getResponse()->setBody($result);
    }
    
    public function massDeleteAction() {
        $productlookbookIds = $this->getRequest()->getParam('productlookbook');
        if(!is_array($productlookbookIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select slide(s)'));
        } else {
            try {
                foreach ($productlookbookIds as $productlookbookId) {
                    $productlookbook = Mage::getModel('productlookbook/productlookbook')->load($productlookbookId);
                    $productlookbook->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($productlookbookIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $productlookbookIds = $this->getRequest()->getParam('productlookbook');
        if(!is_array($productlookbookIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select slide(s)'));
        } else {
            try {
                foreach ($productlookbookIds as $productlookbookId) {
                    $productlookbook = Mage::getSingleton('productlookbook/productlookbook')
                        ->load($productlookbookId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($productlookbookIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'productlookbook.csv';
        $content    = $this->getLayout()->createBlock('productlookbook/adminhtml_productlookbook_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'productlookbook.xml';
        $content    = $this->getLayout()->createBlock('productlookbook/adminhtml_productlookbook_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}