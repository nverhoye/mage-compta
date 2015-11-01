<?php

/**
 * Job Model
 *
 * @category    Gpec
 * @package     Gpec_report
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Report_Model_Report extends Mage_Core_Model_Abstract
{

    /**
     * Report directory
     */
    const REPORT_DIRECTORY = 'report/';


    const TYPE_EDP = 1;
    const TYPE_SUIVI = 2;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('gpec_report/report');
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
