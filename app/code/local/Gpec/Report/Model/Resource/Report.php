<?php

class Gpec_Report_Model_Resource_Report extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();

        $this->_reportTable = $this->getTable('gpec_report/report');
    }

    public function _construct()
    {
        $this->_init('gpec_report/report', 'report_id');
    }

    /**
     * Get user ides
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getUserIds($report)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'report_id' => (int) $report->getId()
        );

        $select = $read->select()
            ->from($this->_reportUserTable, array('user_id'))
            ->where('report_id = :report_id');

        return $read->fetchCol($select, $binds);
    }

    /**
     * @param Gpec_Report_Model_Report $model
     * @return $this
     */
    public function _saveUserIds($model)
    {
        $addedIds = $model->getPostedUserIds();

        if(!is_array($addedIds)){
            return $this;
        }

        $bind = array(
            'report_id'   => $model->getId(),
        );
        $write = $this->_getWriteAdapter();

        $select = $write->select()
            ->from($this->_reportUserTable, 'user_id')
            ->where('report_id = :report_id');
        $oldRelationIds = $write->fetchCol($select, $bind);

        $insert = array_diff($addedIds, $oldRelationIds);
        $delete = array_diff($oldRelationIds, $addedIds);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $value) {
                $insertData[] = array(
                    'report_id'    => $model->getId(),
                    'user_id'    => $value,
                );
            }
            $write->insertMultiple($this->_reportUserTable, $insertData);
        }

        if (!empty($delete)) {
            $write->delete($this->_reportUserTable, array(
                'user_id IN (?)' => $delete,
                'report_id'    => $model->getId()
            ));
        }

        return $this;
    }

    /**
     * Process job data before save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Gpec_report_Model_Resource_Job
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        /**
         * Update timestamp values
         */
        $date = $this->formatDate(Mage::getModel('core/date')->gmtTimestamp());
        if (! $object->getCreatedAt()) {
            $object->setCreatedAt($date);
        }
        $object->setUpdatedAt($date);
        
        return parent::_beforeSave($object);
    }

    /**
     * Process slider data after save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Atecna_Slider_Model_Resource_Slider
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        //$this->_saveUserIds($object);
        return parent::_afterSave($object);
    }
}
