<?php

/**
 * Admin customer left menu
 *
 * @category   Compta
 * @package    Compta_customer
 * @author     Compta <contact@compta.fr>
 */
class Compta_Customer_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('compta_customer')->__('Modifier le client'));
    }

    protected function _prepareLayout()
    {

        $this->addTab('main_section', array(
            'label'     => Mage::helper('compta_customer')->__('Information'),
            'title'     => Mage::helper('compta_customer')->__('Information'),
            'content'   =>$this->getLayout()->createBlock('compta_customer/adminhtml_customer_edit_tab_main')->toHtml(),
        ));

        return parent::_prepareLayout();
    }
}
