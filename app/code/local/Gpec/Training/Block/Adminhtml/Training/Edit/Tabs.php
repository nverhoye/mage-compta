<?php

/**
 * Admin job left menu
 *
 * @category   Gpec
 * @package    Gpec_training
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Training_Block_Adminhtml_Training_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('training_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('gpec_training')->__('Modifier la formation'));
    }

    protected function _prepareLayout()
    {

        $this->addTab('main_section', array(
            'label'     => Mage::helper('gpec_training')->__('Information'),
            'title'     => Mage::helper('gpec_training')->__('Information'),
            'content'   =>$this->getLayout()->createBlock('gpec_training/adminhtml_training_edit_tab_main')->toHtml(),
        ));

        $this->addTab('user_section', array(
            'label'     => Mage::helper('gpec_training')->__('Participants'),
            'title'     => Mage::helper('gpec_training')->__('Participants'),
            'url'       => $this->getUrl('*/*/user', array('_current' => true)),
            'class'     => 'ajax',
        ));

        return parent::_prepareLayout();
    }
}
