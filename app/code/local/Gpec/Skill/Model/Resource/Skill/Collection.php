<?php

class Gpec_Skill_Model_Resource_Skill_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('gpec_skill/skill');
    }

}
