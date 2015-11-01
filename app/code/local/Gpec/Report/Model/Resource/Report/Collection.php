<?php

class Gpec_Report_Model_Resource_Report_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('gpec_report/report');
    }

}
