<?php

class Gpec_Job_Model_Resource_User extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();

        $this->_jobUserTable = $this->getTable('gpec_job/user');
    }

    public function _construct()
    {
        $this->_init('gpec_job/user', 'entity_id');
    }

    public function getJobId($user)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'user_id' => $user->getUserId()
        );

        $select = $read->select()
            ->from($this->_jobUserTable, array('job_id'))
            ->where('user_id = :user_id')
            ->limit(1);

        $res = $read->fetchRow($select, $binds);

        return isset($res['job_id']) ? $res['job_id'] : false;
    }

}
