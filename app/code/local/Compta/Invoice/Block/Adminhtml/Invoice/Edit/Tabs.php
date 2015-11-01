<?php

/**
 * Admin invoice left menu
 *
 * @category   Compta
 * @package    Compta_invoice
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Invoice_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('invoice_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('compta_invoice')->__('Modifier la facture'));
    }

    protected function _prepareLayout()
    {

        $this->addTab('main_section', array(
            'label'     => Mage::helper('compta_invoice')->__('Information'),
            'title'     => Mage::helper('compta_invoice')->__('Information'),
            'content'   =>$this->getLayout()->createBlock('compta_invoice/adminhtml_invoice_edit_tab_main')->toHtml(),
        ));

        return parent::_prepareLayout();
    }
}
