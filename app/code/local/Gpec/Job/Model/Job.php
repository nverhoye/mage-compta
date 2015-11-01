<?php

/**
 * Job Model
 *
 * @category    Gpec
 * @package     Gpec_Job
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Job_Model_Job extends Mage_Core_Model_Abstract
{

    const JOB_DIRECTORY = 'job/';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('gpec_job/job');
    }

    public function getSkillIds()
    {
        if (!$this->hasData('skill_ids')) {
            $items = $this->_getResource()->getSkillIds($this);
            $this->setData('skill_ids', $items);
        }

        return (array)$this->getData('skill_ids');
    }
}
