<?php

/**
 * Adminhtml skill content
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Skill extends Mage_Core_Block_Template
{
    public function getSkills()
    {
        $skills = array();
        if($jobId = $this->getJobId()) {
            $job = Mage::getModel('gpec_job/job')->load($jobId);
            $skills = Mage::getResourceModel('gpec_job/job')->getSkills($job);
        }
        return $skills;
    }
}
