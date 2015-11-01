<?php

/**
 * Customer Model
 *
 * @category    Compta
 * @package     Compta_customer
 * @author      Compta <contact@compta.fr>
 */
class Compta_Customer_Model_Customer extends Mage_Core_Model_Abstract
{

    /**
     * Customer directory
     */
    const REPORT_DIRECTORY = 'customer/';


    const TYPE_EDP = 1;
    const TYPE_SUIVI = 2;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('compta_customer/customer');
    }

    public function getTypes()
    {
        return array(
            self::TYPE_EDP => 'EDP',
            self::TYPE_SUIVI => 'Suivi',
        );
    }

    public function getType($typeId)
    {
        $types = $this->getTypes();
        return $types[$typeId];
    }

}
