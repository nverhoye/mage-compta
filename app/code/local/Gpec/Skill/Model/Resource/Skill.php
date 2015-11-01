<?php

class Gpec_Skill_Model_Resource_Skill extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();
        $this->_jobSkillTable = $this->getTable('gpec_job/skill');
    }

    public function _construct()
    {
        $this->_init('gpec_skill/skill', 'skill_id');
    }

    /**
     * Get job ids
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getJobIds($skill)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'skill_id' => (int)$skill->getId()
        );

        $select = $read->select()
            ->from($this->_jobSkillTable, array('job_id'))
            ->where('skill_id = :skill_id');

        return $read->fetchCol($select, $binds);
    }

    /**
     * @param Gpec_Job_Model_Job $model
     * @return $this
     */
    public function _saveJobIds($model)
    {
        $addedIds = $model->getPostedJobIds();

        if(!is_array($addedIds)){
            return $this;
        }

        $bind = array(
            'skill_id'   => $model->getId(),
        );
        $write = $this->_getWriteAdapter();

        $select = $write->select()
            ->from($this->_jobSkillTable, 'job_id')
            ->where('skill_id = :skill_id');
        $oldRelationIds = $write->fetchCol($select, $bind);

        $insert = array_diff($addedIds, $oldRelationIds);
        $delete = array_diff($oldRelationIds, $addedIds);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $value) {
                if((int)$value != 0) {
                    $insertData[] = array(
                        'skill_id'    => $model->getId(),
                        'job_id'    => $value,
                    );
                }
            }
            if($insertData) {
                $write->insertMultiple($this->_jobSkillTable, $insertData);
            }
        }

        if (!empty($delete)) {
            $write->delete($this->_jobSkillTable, array(
                'skill_id'    => $model->getId(),
                'job_id IN (?)' => $delete
            ));
        }

        return $this;
    }


    /**
     * Process skill data before save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Gpec_Skill_Model_Resource_Skill
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        /**
         * Update timestamp values
         */
        $date = $this->formatDate(Mage::getModel('core/date')->gmtTimestamp());
        if (!$object->getCreatedAt()) {
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
        $this->_saveJobIds($object);
        return parent::_afterSave($object);
    }


}
