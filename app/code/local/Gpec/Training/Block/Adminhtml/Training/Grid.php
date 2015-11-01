<?php

/**
 * Adminhtml jobs grid
 *
 * @category   Gpec
 * @package    Gpec_training
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Training_Block_Adminhtml_Training_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('trainingGrid');
        $this->setDefaultSort('training_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('gpec_training/training')->getCollection();
        /* @var $collection Gpec_Training_Model_Resource_Job_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name',
            array(
                'header' => Mage::helper('gpec_training')->__('Formation'),
                'align' => 'left',
                'index' => 'name'
            ));

        $this->addColumn('trainer',
            array(
                'header' => Mage::helper('gpec_training')->__('Organisateur'),
                'align' => 'left',
                'index' => 'trainer'
            ));

        $this->addColumn('started_at',
            array(
                'header' => Mage::helper('gpec_training')->__('Date de début'),
                'index' => 'started_at',
                'type' => 'datetime'
            ));

        $this->addColumn('ended_at',
            array(
                'header' => Mage::helper('gpec_training')->__('Date de fin'),
                'index' => 'ended_at',
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
            'training_id' => $row->getId()
        ));
    }
}
