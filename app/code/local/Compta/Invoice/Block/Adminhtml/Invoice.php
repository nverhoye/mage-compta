<?php

/**
 * Adminhtml invoice content
 *
 * @category   Compta
 * @package    Compta_invoice
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Invoice extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_invoice';
        $this->_blockGroup = 'compta_invoice';
        $this->_headerText = Mage::helper('compta_invoice')->__('Gestion des factures');

        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('compta_invoice')->__('Ajouter une facture'));

    }

    /**
     * Check permission for passed action
     *
     * @param string $action            
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('invoice/' . $action);
    }
}
