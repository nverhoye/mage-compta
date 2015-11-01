<?php

/**
 * Adminhtml skills grid
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('skillGrid');
        $this->setDefaultSort('skill_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('gpec_skill/skill')->getCollection();
        /* @var $collection Gpec_Skill_Model_Resource_Skill_Collection */
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        
        $this->addColumn('category',
                array(
                        'header' => Mage::helper('gpec_skill')->__('Catégorie'),
                        'align' => 'left',
                        'index' => 'category'
                ));
        
        $this->addColumn('name',
                array(
                        'header' => Mage::helper('gpec_skill')->__('Nom'),
                        'align' => 'left',
                        'index' => 'name'
                ));

        
        $this->addColumn('creation_time', 
                array(
                        'header' => Mage::helper('gpec_skill')->__('Date Created'),
                        'index' => 'created_at',
                        'type' => 'datetime'
                ));
        
        $this->addColumn('update_time', 
                array(
                        'header' => Mage::helper('gpec_skill')->__('Last Modified'),
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
                'skill_id' => $row->getId()
        ));
    }
}
