<?php

/**
 * Admin skill left menu
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('skill_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('gpec_skill')->__('Modifier la compétence'));
    }

    protected function _prepareLayout()
    {

        $this->addTab('main_section', array(
            'label'     => Mage::helper('gpec_skill')->__('Information'),
            'title'     => Mage::helper('gpec_skill')->__('Information'),
            'content'   =>$this->getLayout()->createBlock('gpec_skill/adminhtml_skill_edit_tab_main')->toHtml(),
        ));

        $this->addTab('job_section', array(
            'label'     => Mage::helper('gpec_skill')->__('Postes'),
            'title'     => Mage::helper('gpec_skill')->__('Postes'),
            'url'       => $this->getUrl('*/*/job', array('_current' => true)),
            'class'     => 'ajax',
        ));

        return parent::_prepareLayout();
    }
}
