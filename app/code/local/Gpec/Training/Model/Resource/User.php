<?php

class Gpec_Training_Model_Resource_User extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('gpec_training/user', 'entity_id');
    }

}
