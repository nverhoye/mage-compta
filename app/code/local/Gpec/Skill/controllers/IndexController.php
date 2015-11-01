<?php

/**
 * Manage skills controller
 *
 * @category    Gpec
 * @package     Gpec_Skill
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Skill_IndexController extends Mage_Core_Controller_Front_Action
{
    public function listAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('skill.list')
            ->setJobId($this->getRequest()->getPost('job_id'));
        $this->renderLayout();
    }

}
