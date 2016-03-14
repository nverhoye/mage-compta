<?php

class Compta_Calendar_Model_Resource_Calendar_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _constuct()
    {
        $this->_init('compta_calendar/calendar');

    }
}
