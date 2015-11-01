<?php

/**
 * Shop categories tab
 *
 * @category   Atecna
 * @package    Atecna_Shop
 * @author     Atecna <contact@atecna.fr>
 */
class Gpec_Job_Block_Adminhtml_Job_Edit_Tab_Skill
    extends  Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('skill_job_grid');
        $this->setDefaultSort('skill_id');
        $this->setUseAjax(true);
        if ($this->_getJob()->getId()) {
           $this->setDefaultFilter(array('in_skill'=>1));
        }
    }

    /**
     * Add websites to sales rules collection
     * Set collection
     *
     * @return Mage_Adminhtml_Block_Promo_Quote_Grid
     */
    protected function _prepareCollection()
    {
        /** @var $collection Mage_SalesRule_Model_Mysql4_Rule_Collection */
        $collection = Mage::getModel('gpec_skill/skill')
            ->getResourceCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Crosssell
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_skill') {
            $salestuleIds = $this->_getSelectedSkill();
            if (empty($salestuleIds)) {
                $salestuleIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('skill_id', array('in'=>$salestuleIds));
            } else {
                if($salestuleIds) {
                    $this->getCollection()->addFieldToFilter('skill_id', array('nin'=>$salestuleIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareColumns()
    {

        parent::_prepareColumns();
        $this->addColumn('in_skill', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'field_name'        => 'posted_skill_ids[]',
            'values'            => $this->_getSelectedSkill(),
            'align'             => 'center',
            'index'             => 'skill_id',
        ));

        $this->addColumn('s_category', array(
            'header'    => Mage::helper('gpec_job')->__('Catégorie'),
            'align'     =>'left',
            'index'     => 'category',
            'width' => '15%'
        ));

        $this->addColumn('s_name', array(
            'header'    => Mage::helper('gpec_job')->__('Nom'),
            'align'     => 'left',
            'index'     => 'name',
            'width' => '80%'
        ));

        return $this;
    }

    protected function _getSelectedSkill()
    {
        return array_keys($this->getSelectedSkill());
    }

    public function getSelectedSkill()
    {
        $selectedSkill = array();

        if($jobId = $this->getRequest()->getParam('job_id', false)) {
            $job = Mage::getModel('gpec_job/job')->load($jobId);
            foreach($job->getSkillIds() as $skillId) {
                $selectedSkill[$skillId] = $skillId;
            }
        }

        return $selectedSkill;
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/skillgrid', array('_current'=>true));
    }

    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getJob()
    {
        return Mage::registry('current_job');
    }


}
