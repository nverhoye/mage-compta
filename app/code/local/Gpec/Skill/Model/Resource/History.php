<?php

class Gpec_Skill_Model_Resource_Historic extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('gpec_skill/historic', 'historic_id');
    }

}
