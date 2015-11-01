<?php

class Gpec_Training_Model_Resource_Training extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();

        $this->_trainingTable = $this->getTable('gpec_training/training');
        $this->_trainingUserTable = $this->getTable('gpec_training/user');
    }

    public function _construct()
    {
        $this->_init('gpec_training/training', 'training_id');
    }

    /**
     * Get user ides
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getUserIds($training)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'training_id' => (int) $training->getId()
        );

        $select = $read->select()
            ->from($this->_trainingUserTable, array('user_id'))
            ->where('training_id = :training_id');

        return $read->fetchCol($select, $binds);
    }

    /**
     * @param Gpec_Training_Model_Training $model
     * @return $this
     */
    public function _saveUserIds($model)
    {
        $addedIds = $model->getPostedUserIds();

        if(!is_array($addedIds)){
            return $this;
        }

        $bind = array(
            'training_id'   => $model->getId(),
        );
        $write = $this->_getWriteAdapter();

        $select = $write->select()
            ->from($this->_trainingUserTable, 'user_id')
            ->where('training_id = :training_id');
        $oldRelationIds = $write->fetchCol($select, $bind);

        $insert = array_diff($addedIds, $oldRelationIds);
        $delete = array_diff($oldRelationIds, $addedIds);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $value) {
                $insertData[] = array(
                    'training_id'    => $model->getId(),
                    'user_id'    => $value,
                );
            }
            $write->insertMultiple($this->_trainingUserTable, $insertData);
        }

        if (!empty($delete)) {
            $write->delete($this->_trainingUserTable, array(
                'user_id IN (?)' => $delete,
                'training_id'    => $model->getId()
            ));
        }

        return $this;
    }

    /**
     * Process job data before save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Gpec_training_Model_Resource_Job
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
        $this->_saveUserIds($object);
        return parent::_afterSave($object);
    }
}
