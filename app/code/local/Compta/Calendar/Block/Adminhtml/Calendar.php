<?php

class Compta_Calendar_Block_Adminhtml_Calendar
    extends Mage_AdminHtml_Block_Template
{

    protected $_collection = array();
/*
    public function __construct()
    {

        if (empty($this->_collection)) {
            $this->_collection = $this->getCollection();
        }
    }*/

    public function getAllMonths()
    {
        return Mage::helper('compta_calendar')->getAllMonths();
    }

    public function getCollection()
    {
        return Mage::helper('compta_calendar')->getAllIncalendar();
    }

    public function getIncalendar($key)
    {
        if (isset($this->_collection[$key])) {
            return $this->_collection[$key];
        }
        return false;
    }

}
