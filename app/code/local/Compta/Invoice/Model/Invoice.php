<?php

/**
 * Invoice Model
 *
 * @category    Compta
 * @package     Compta_invoice
 * @author      Compta <contact@compta.fr>
 */
class Compta_Invoice_Model_Invoice extends Mage_Core_Model_Abstract
{

    /**
     * Invoice directory
     */
    const INVOICE_DIRECTORY = 'invoice/';


    const TYPE_EDP = 1;
    const TYPE_SUIVI = 2;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('compta_invoice/invoice');
    }


}
