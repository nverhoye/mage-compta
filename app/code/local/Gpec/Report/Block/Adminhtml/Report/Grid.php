<?php

/**
 * Adminhtml jobs grid
 *
 * @category   Gpec
 * @package    Gpec_report
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Report_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reportGrid');
        $this->setDefaultSort('report_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('gpec_report/report')->getCollection();
        /* @var $collection Gpec_Report_Model_Resource_Job_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('type_id',
            array(
                'header' => Mage::helper('gpec_report')->__('Type'),
                'align' => 'left',
                'index' => 'type_id',
                'type' => 'options',
                'options' => Mage::getModel('gpec_report/report')->getTypes()
            ));

        $this->addColumn('name',
            array(
                'header' => Mage::helper('gpec_report')->__('Nom'),
                'align' => 'left',
                'index' => 'name'
            ));

        $this->addColumn('author_id',
            array(
                'header' => Mage::helper('gpec_report')->__('Auteur'),
                'align' => 'left',
                'index' => 'author_id',
                'renderer' => 'Gpec_User_Block_Adminhtml_Renderer_Fullname'
            ));

        $this->addColumn('user_id',
            array(
                'header' => Mage::helper('gpec_report')->__('Assigné à'),
                'align' => 'left',
                'index' => 'user_id',
                'renderer' => 'Gpec_User_Block_Adminhtml_Renderer_Fullname'
            ));

        $this->addColumn('created_at',
            array(
                'header' => Mage::helper('gpec_report')->__('Date de création'),
                'index' => 'created_at',
                'type' => 'datetime'
            ));

        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'report_id' => $row->getId()
        ));
    }
}
