<?php

/**
 * Admin job left menu
 *
 * @category   Gpec
 * @package    Gpec_report
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Report_Block_Adminhtml_Report_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('report_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('gpec_report')->__('Modifier la formation'));
    }

    protected function _prepareLayout()
    {

        $this->addTab('main_section', array(
            'label'     => Mage::helper('gpec_report')->__('Information'),
            'title'     => Mage::helper('gpec_report')->__('Information'),
            'content'   =>$this->getLayout()->createBlock('gpec_report/adminhtml_report_edit_tab_main')->toHtml(),
        ));

        return parent::_prepareLayout();
    }
}
