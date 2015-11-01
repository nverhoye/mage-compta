<?php

/**
 * Admin Invoice
 *
 * @category   Compta
 * @package    Compta_invoice
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Invoice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Initialize invoice edit block
     *
     * @return void
     */
    public function __construct()
    {
        $this->_objectId = 'invoice_id';
        $this->_controller = 'adminhtml_invoice';
        $this->_blockGroup = 'compta_invoice';
        
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('compta_invoice')->__('Save'));
        $this->_addButton('saveandcontinue',
                array(
                        'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                        'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                        'class' => 'save'
                ), - 100);

        $this->_formScripts[] = 'function saveAndContinueEdit() {
        editForm.submit($(\'edit_form\').action + \'back/edit/\');}';


        $this->_updateButton('delete', 'label', Mage::helper('compta_invoice')->__('Delete'));

    }

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }
        return $this->getUrl('*/*/save');
    }

    /**
     * Retrieve text for header element depending on loaded invoice
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_invoice')->getId()) {
            return Mage::helper('compta_invoice')->__("Modifier la facture %s", $this->htmlEscape(Mage::registry('current_invoice')->getNumber()));
        } else {
            return Mage::helper('compta_invoice')->__("Saisie d'une nouvelle facture");
        }
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', 
                array(
                        '_current' => true,
                        'back' => 'edit',
                        'active_tab' => '{{tab_id}}'
                ));
    }

    /**
     * Prepare layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setCanLoadExtJs(true);
        }
        return parent::_prepareLayout();
    }
}
