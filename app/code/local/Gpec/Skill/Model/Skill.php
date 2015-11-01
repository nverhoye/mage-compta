<?php

/**
 * Skill Model
 *
 * @category    Gpec
 * @package     Gpec_Skill
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Model_Skill extends Mage_Core_Model_Abstract
{
    
    /**
     * Skill directory
     */
    const SERVICE_DIRECTORY = 'skill/';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('gpec_skill/skill');
    }

    public function getFullName()
    {
        return $this->getData('category') . ' - ' . $this->getData('name');
    }

    /**
     * @return array
     */
    public function getJobIds()
    {
        if (!$this->hasData('job_ids')) {
            $items = $this->_getResource()->getJobIds($this);
            $this->setData('job_ids', $items);
        }

        return (array)$this->getData('job_ids');
    }
}
