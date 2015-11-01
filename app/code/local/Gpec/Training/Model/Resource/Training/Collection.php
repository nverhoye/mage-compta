<?php

class Gpec_Training_Model_Resource_Training_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('gpec_training/training');
    }

}
