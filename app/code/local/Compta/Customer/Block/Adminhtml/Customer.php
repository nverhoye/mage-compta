<?php

/**
 * Adminhtml customer content
 *
 * @category   Compta
 * @package    Compta_customer
 * @author     Compta <contact@compta.fr>
 */
class Compta_Customer_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_customer';
        $this->_blockGroup = 'compta_customer';
        $this->_headerText = Mage::helper('compta_customer')->__('Gestion des clients');

        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('compta_customer')->__('Ajouter un client'));

    }

    /**
     * Check permission for passed action
     *
     * @param string $action            
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('customer/' . $action);
    }
}
