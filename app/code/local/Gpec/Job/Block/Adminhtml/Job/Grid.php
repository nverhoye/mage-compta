<?php

/**
 * Adminhtml jobs grid
 *
 * @category   Gpec
 * @package    Gpec_Job
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Job_Block_Adminhtml_Job_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('jobGrid');
        $this->setDefaultSort('job_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('gpec_job/user')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToSelect(new Zend_Db_Expr("count(*) as total"));
        $collection->getSelect()
            ->joinLeft('gpec_job', 'gpec_job.job_id = main_table.job_id');
        $collection->getSelect()->group(new Zend_Db_Expr("main_table.job_id"))
            ->order('total DESC');

        /* @var $collection Gpec_Job_Model_Resource_Job_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name',
            array(
                'header' => Mage::helper('gpec_job')->__('Poste'),
                'align' => 'left',
                'index' => 'name'
            ));

        $this->addColumn('total',
            array(
                'header' => Mage::helper('gpec_job')->__('Nombre de collaborateurs'),
                'align' => 'left',
                'index' => 'total',
                'filter' => false,
            ));

        $this->addColumn('creation_time',
            array(
                'header' => Mage::helper('gpec_job')->__('Date Created'),
                'index' => 'created_at',
                'type' => 'datetime'
            ));

        $this->addColumn('update_time',
            array(
                'header' => Mage::helper('gpec_job')->__('Last Modified'),
                'index' => 'updated_at',
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
            'job_id' => $row->getData('job_id')
        ));
    }
}
