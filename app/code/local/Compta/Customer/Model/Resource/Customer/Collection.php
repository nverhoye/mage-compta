<?php

class Compta_Customer_Model_Resource_Customer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('compta_customer/customer');
    }

}
