<?php

/**
 * Admin job left menu
 *
 * @category   Gpec
 * @package    Gpec_Job
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Job_Block_Adminhtml_Job_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('job_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('gpec_job')->__('Modifier le poste'));
    }

    protected function _prepareLayout()
    {

        $this->addTab('main_section', array(
            'label'     => Mage::helper('gpec_job')->__('Information'),
            'title'     => Mage::helper('gpec_job')->__('Information'),
            'content'   =>$this->getLayout()->createBlock('gpec_job/adminhtml_job_edit_tab_main')->toHtml(),
        ));

        $this->addTab('skill_section', array(
            'label'     => Mage::helper('gpec_job')->__('Compétences du poste'),
            'title'     => Mage::helper('gpec_job')->__('Compétences du poste'),
            'url'       => $this->getUrl('*/*/skill', array('_current' => true)),
            'class'     => 'ajax',
        ));

        return parent::_prepareLayout();
    }
}
