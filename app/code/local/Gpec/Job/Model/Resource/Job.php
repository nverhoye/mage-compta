<?php

class Gpec_Job_Model_Resource_Job extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();

        $this->_jobTable = $this->getTable('gpec_job/job');
        $this->_jobSkillTable = $this->getTable('gpec_job/skill');
        $this->_skillTable = $this->getTable('gpec_skill/skill');
    }

    public function _construct()
    {
        $this->_init('gpec_job/job', 'job_id');
    }

    /**
     * Get slider products
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getSkillIds($job)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'job_id' => (int) $job->getId()
        );

        $select = $read->select()
            ->from($this->_jobSkillTable, array('skill_id'))
            ->where('job_id = :job_id');

        return $read->fetchCol($select, $binds);
    }


    /**
     * Get slider products
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getSkills($job)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'job_id' => (int) $job->getId()
        );

        $select = $read->select()
            ->from($this->_jobSkillTable, array('skill_id'))
            ->joinLeft($this->_skillTable, "gpec_skill.skill_id=gpec_job_skill.skill_id")
            ->where('gpec_job_skill.job_id = :job_id');

        return $read->fetchAll($select, $binds);
    }

    /**
     * @param Gpec_Job_Model_Job $model
     * @return $this
     */
    public function _saveSkillIds($model)
    {
        $addedIds = $model->getPostedSkillIds();

        $jobId = $model->getId();

        if(!is_array($addedIds) or empty($jobId)){
            return $this;
        }

        $bind = array(
            'job_id'   => $jobId,
        );

        $write = $this->_getWriteAdapter();

        $select = $write->select()
            ->from($this->_jobSkillTable, 'skill_id')
            ->where('job_id = :job_id');
        $oldRelationIds = $write->fetchCol($select, $bind);

        $insert = array_diff($addedIds, $oldRelationIds);
        $delete = array_diff($oldRelationIds, $addedIds);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $value) {
                $insertData[] = array(
                    'job_id'    => $model->getId(),
                    'skill_id'    => $value,
                );
            }
            $write->insertMultiple($this->_jobSkillTable, $insertData);
        }

        if (!empty($delete)) {
            $write->delete($this->_jobSkillTable, array(
                'skill_id IN (?)' => $delete,
                'job_id'    => $model->getId()
            ));
        }

        return $this;
    }

    /**
     * Process job data before save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Gpec_Job_Model_Resource_Job
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
        $this->_saveSkillIds($object);
        return parent::_afterSave($object);
    }
}
