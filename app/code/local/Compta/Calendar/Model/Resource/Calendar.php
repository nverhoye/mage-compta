<?php

class Compta_Calendar_Model_Resource_Calendar
    extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('compta_calendar/calendar', 'calendar_id');
    }
}
