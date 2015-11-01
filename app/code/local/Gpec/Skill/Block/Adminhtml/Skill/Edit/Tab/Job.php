<?php

/**
 * Shop categories tab
 *
 * @category   Atecna
 * @package    Atecna_Shop
 * @author     Atecna <contact@atecna.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill_Edit_Tab_Job
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('skill_job_grid');
        $this->setDefaultSort('job_id');
        $this->setUseAjax(true);
        if ($this->_getSkill()->getId()) {
            $this->setDefaultFilter(array('in_job' => 1));
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
        $collection = Mage::getModel('gpec_job/job')
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
        return $this;
        // Set custom filter for in product flag
        if ($column->getId() == 'in_job') {
            $jobIds = $this->_getSelectedJob();
            if (empty($jobIds)) {
                $jobIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('job_id', array('in' => $jobIds));
            } else {
                if ($jobIds) {
                    $this->getCollection()->addFieldToFilter('job_id', array('nin' => $jobIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareColumns()
    {

        $this->addColumn('in_job', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'field_name' => 'posted_job_ids[]',
            'values' => $this->_getSelectedJob(),
            'align' => 'center',
            'index' => 'job_id',
        ));

        $this->addColumn('s_name', array(
            'header' => Mage::helper('gpec_skill')->__('Nom'),
            'align' => 'left',
            'index' => 'name',
            //'width' => '80%'
        ));


        parent::_prepareColumns();
        return $this;
    }

    protected function _getSelectedJob()
    {
        return array_keys($this->getSelectedJob());
    }

    public function getSelectedJob()
    {
        $selectedJob = array();

        if ($skillId = $this->getRequest()->getParam('skill_id', false)) {
            $skill = Mage::getModel('gpec_skill/skill')->load($skillId);
            $jobIds = $skill->getJobIds();
            foreach ($jobIds as $job) {
                $selectedJob[$job] = $job;
            }
        }

        return $selectedJob;
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/jobgrid', array('_current' => true));
    }

    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getSkill()
    {
        return Mage::registry('current_skill');
    }


}
