<?php

/**
 * Manage skills controller
 *
 * @category    Gpec
 * @package     Gpec_Skill
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Adminhtml_Skill_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Gpec_Skill_Adminhtml_SkillController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('gpec_skill')
            ->_addBreadcrumb(Mage::helper('gpec_skill')->__('Skill'), Mage::helper('gpec_skill')->__('Skill'))
            ->_addBreadcrumb(Mage::helper('gpec_skill')->__('Manage Skills'), Mage::helper('gpec_skill')->__('Manage Skills'));
        return $this;
    }

    /**
     * Initialize skill from request parameters
     *
     * @return Gpec_Skill_Model_Skill
     */
    protected function _initSkill()
    {
        $id = (int)$this->getRequest()->getParam('skill_id');
        $model = Mage::getModel('gpec_skill/skill')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_skill', $model);
        return $model;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Manage Skills'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Skill
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Skill
     */
    public function editAction()
    {
        $model = $this->_initSkill();
        $this->_title($model->getId() ? $model->getName() : $this->__('New Skill'));

        $id = (int)$this->getRequest()->getParam('skill_id');

        $this->_initAction($model)->_addBreadcrumb($id ? Mage::helper('gpec_skill')->__('Edit Skill') : Mage::helper('gpec_skill')->__('New Skill'),
            $id ? Mage::helper('gpec_skill')->__('Edit Skill') : Mage::helper('gpec_skill')->__('New Skill'));
        $this->renderLayout();
    }

    /**
     * Initialize skill before saving
     */
    protected function _initSkillSave()
    {
        $skill = $this->_initSkill();
        $skillData = $this->getRequest()->getPost();
        if ($skillData) {
            $skillData = $this->_filterPostData($skillData);
        }

        // validating
        if (!$this->_validatePostData($skillData)) {
            $this->_redirect('*/*/edit', array(
                'skill_id' => $model->getId(),
                '_current' => true
            ));
            return;
        }

        $skill->addData($skillData);

        Mage::dispatchEvent('gpec_skill_prepare_save',
            array(
                'skill' => $skill,
                'request' => $this->getRequest()
            ));

        return $skill;
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $model = $this->_initSkillSave();

            // try to save it
            try {

                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gpec_skill')->__('The skill has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit',
                        array(
                            'skill_id' => $model->getId(),
                            '_current' => true
                        ));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e, Mage::helper('gpec_skill')->__('An error occurred while saving the skill.' . $e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit',
                array(
                    'skill_id' => $this->getRequest()
                        ->getParam('skill_id')
                ));
            return;
        }
        $this->_redirect('*/*/');
    }


    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('skill_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('gpec_skill/skill');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gpec_skill')->__('The skill has been deleted.'));
                // go to grid
                Mage::dispatchEvent('gpec_skill_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'success'
                    ));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('gpec_skill_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'fail'
                    ));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array(
                    'skill_id' => $id
                ));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gpec_skill')->__('Unable to find a skill to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Filtering posted data.
     * Converting localized data if needed
     *
     * @param
     *            array
     * @return array
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array(
            'custom_theme_from',
            'custom_theme_to'
        ));
        return $data;
    }

    /**
     * Validate post data
     *
     * @param array $data
     * @return bool Return FALSE if someone item is invalid
     */
    protected function _validatePostData($data)
    {
        $errorNo = true;
        return $errorNo;
    }

    public function jobAction()
    {
        $this->_initSkill();
        $this->loadLayout();
        $this->getLayout()->getBlock('job.grid')
            ->setSkillIds($this->getRequest()->getPost('job_ids'));
        $this->renderLayout();
    }

    public function jobgridAction()
    {
        $this->_initSkill();
        $this->loadLayout();
        $this->getLayout()->getBlock('job.grid')
            ->setSkillIds($this->getRequest()->getPost('job_ids'));
        $this->renderLayout();
    }

    public function manageAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('skill.manage')
          ->setJobId($this->getRequest()->getParam('job_id'));
        $this->renderLayout();
    }


}
