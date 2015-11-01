<?php

/**
 * Manage jobs controller
 *
 * @category    Gpec
 * @package     Gpec_training
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Training_Adminhtml_Training_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Gpec_training_Adminhtml_JobController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('gpec_training')
            ->_addBreadcrumb(Mage::helper('gpec_training')->__('Training'), Mage::helper('gpec_training')->__('Training'))
            ->_addBreadcrumb(Mage::helper('gpec_training')->__('Manage Training'), Mage::helper('gpec_training')->__('Manage Training'));
        return $this;
    }

    /**
     * Initialize job from request parameters
     *
     * @return Gpec_training_Model_Job
     */
    protected function _initTraining()
    {
        $id = (int)$this->getRequest()->getParam('training_id');
        $model = Mage::getModel('gpec_training/training')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_training', $model);
        return $model;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Manage Training'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Job
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Job
     */
    public function editAction()
    {
        $model = $this->_initTraining();
        $this->_title($model->getId() ? $model->getName() : $this->__('New Job'));

        $id = (int)$this->getRequest()->getParam('training_id');

        $this->_initAction($model)->_addBreadcrumb($id ? Mage::helper('gpec_training')->__('Edit Job') : Mage::helper('gpec_training')->__('New Job'),
            $id ? Mage::helper('gpec_training')->__('Edit Job') : Mage::helper('gpec_training')->__('New Job'));
        $this->renderLayout();
    }

    /**
     * Initialize job before saving
     */
    protected function _initTrainingSave()
    {
        $training = $this->_initTraining();
        $trainingData = $this->getRequest()->getPost();
        if ($trainingData) {
            $trainingData = $this->_filterPostData($trainingData);
        }

        // validating
        if (!$this->_validatePostData($trainingData)) {
            $this->_redirect('*/*/edit', array(
                'training_id' => $model->getId(),
                '_current' => true
            ));
            return;
        }

        $training->addData($trainingData);


        Mage::dispatchEvent('gpec_training_prepare_save',
            array(
                'training' => $training,
                'request' => $this->getRequest()
            ));

        return $training;
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $model = $this->_initTrainingSave();

            // try to save it
            try {

                $model = $this->_uploadFile($model);

                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gpec_training')->__('The training has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit',
                        array(
                            'training_id' => $model->getId(),
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
                $this->_getSession()->addException($e, Mage::helper('gpec_training')->__('An error occurred while saving the job.' . $e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit',
                array(
                    'training_id' => $this->getRequest()
                        ->getParam('training_id')
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
        if ($id = $this->getRequest()->getParam('training_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('gpec_training/training');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gpec_training')->__('The job has been deleted.'));
                // go to grid
                Mage::dispatchEvent('gpec_training_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'success'
                    ));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('gpec_training_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'fail'
                    ));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array(
                    'training_id' => $id
                ));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gpec_training')->__('Unable to find a job to delete.'));
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


    public function userAction()
    {
        $this->_initTraining();
        $this->loadLayout();
        $this->getLayout()->getBlock('user.grid')
            ->setUserIds($this->getRequest()->getPost('user_ids'));
        $this->renderLayout();
    }

    public function usergridAction()
    {
        $this->_initTraining();
        $this->loadLayout();
        $this->getLayout()->getBlock('user.grid')
            ->setUserIds($this->getRequest()->getPost('user_ids'));
        $this->renderLayout();
    }

    /**
     * Upload Image Service
     */
    protected function _uploadFile($model)
    {
        $data = array();

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Gpec_Training_Model_Training::TRAINING_DIRECTORY;

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_training')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        /* Small Image */
        if (isset($_FILES['file_path']['name']) && (file_exists($_FILES['file_path']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('file_path');
                $uploader->setAllowedExtensions(
                    array(
                        'jpg',
                        'jpeg',
                        'gif',
                        'png',
                        'gif',
                        'doc',
                        'docx',
                        'xls',
                        'xlsx',
                        'xml',
                        'pdf'
                    ));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);

                $uploader->save($dirPath, $_FILES['file_path']['name']);

                $data['file_path'] = Gpec_Training_Model_Training::TRAINING_DIRECTORY . $uploader->getUploadedFileName();
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $model->unsetData('file_path');
        }

        if ($imagePost = $this->getRequest()->getPost('file_path')) {
            if (isset($imagePost['delete']) && $imagePost['delete'] == 1) {
                $data['image_path'] = '';
            }
        }

        $model->addData($data);

        return $model;
    }

}
