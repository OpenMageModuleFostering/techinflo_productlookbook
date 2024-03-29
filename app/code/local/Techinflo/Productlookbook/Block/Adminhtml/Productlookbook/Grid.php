<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */
class Techinflo_Productlookbook_Block_Adminhtml_Productlookbook_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('productlookbookGrid');
      $this->setDefaultSort('productlookbook_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('productlookbook/productlookbook')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('productlookbook_id', array(
          'header'    => Mage::helper('productlookbook')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'productlookbook_id',
      ));
      
      $this->addColumn( 'image', array(
          'header' => Mage::helper( 'productlookbook' )->__( 'Image' ), 
          'type' => 'image', 
          'width' => '75px', 
          'index' => 'image',
          'filter'    => false,
          'sortable'  => false,
          'renderer' => 'productlookbook/adminhtml_template_grid_renderer_image',
      ));
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('productlookbook')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));

      $this->addColumn('position', array(
          'header'    => Mage::helper('productlookbook')->__('Order'),
          'align'     =>'left',
          'width'     => '50px',
          'index'     => 'position',
      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('productlookbook')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('productlookbook')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('productlookbook')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('productlookbook')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('productlookbook')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productlookbook_id');
        $this->getMassactionBlock()->setFormFieldName('productlookbook');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('productlookbook')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('productlookbook')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productlookbook/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('productlookbook')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('productlookbook')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}