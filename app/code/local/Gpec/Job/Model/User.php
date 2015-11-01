<?php

/**
 * Job Model
 *
 * @category    Gpec
 * @package     Gpec_Job
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Job_Model_User extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('gpec_job/user');
    }

    public function getJobId($user)
    {
        if (!$this->hasData('job_id')) {
            $jobId = $this->_getResource()->getJobId($user);
            $this->setData('job_id', $jobId);
        }

        return (int)$this->getData('job_id');
    }

}