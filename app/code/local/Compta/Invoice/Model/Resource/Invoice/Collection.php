<?php

class Compta_Invoice_Model_Resource_Invoice_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('compta_invoice/invoice');
    }

}
