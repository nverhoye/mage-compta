<?php

/**
 * Manage jobs controller
 *
 * @category    Gpec
 * @package     Gpec_report
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Report_Adminhtml_Report_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Gpec_report_Adminhtml_JobController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('gpec_report')
            ->_addBreadcrumb(Mage::helper('gpec_report')->__('Report'), Mage::helper('gpec_report')->__('Report'))
            ->_addBreadcrumb(Mage::helper('gpec_report')->__('Manage Report'), Mage::helper('gpec_report')->__('Manage Report'));
        return $this;
    }

    /**
     * Initialize job from request parameters
     *
     * @return Gpec_report_Model_Job
     */
    protected function _initReport()
    {
        $id = (int)$this->getRequest()->getParam('report_id');
        $model = Mage::getModel('gpec_report/report')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_report', $model);
        return $model;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Manage Report'));

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
        $model = $this->_initReport();
        $this->_title($model->getId() ? $model->getName() : $this->__('New Job'));

        $id = (int)$this->getRequest()->getParam('report_id');

        $this->_initAction($model)->_addBreadcrumb($id ? Mage::helper('gpec_report')->__('Edit Job') : Mage::helper('gpec_report')->__('New Job'),
            $id ? Mage::helper('gpec_report')->__('Edit Job') : Mage::helper('gpec_report')->__('New Job'));
        $this->renderLayout();
    }

    /**
     * Initialize job before saving
     */
    protected function _initReportSave()
    {
        $report = $this->_initReport();
        $reportData = $this->getRequest()->getPost();
        if ($reportData) {
            $reportData = $this->_filterPostData($reportData);
        }

        // validating
        if (!$this->_validatePostData($reportData)) {
            $this->_redirect('*/*/edit', array(
                'report_id' => $model->getId(),
                '_current' => true
            ));
            return;
        }

        $report->addData($reportData);


        Mage::dispatchEvent('gpec_report_prepare_save',
            array(
                'report' => $report,
                'request' => $this->getRequest()
            ));

        return $report;
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $model = $this->_initReportSave();

            // try to save it
            try {

                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gpec_report')->__('The report has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit',
                        array(
                            'report_id' => $model->getId(),
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
                $this->_getSession()->addException($e, Mage::helper('gpec_report')->__('An error occurred while saving the job.' . $e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit',
                array(
                    'report_id' => $this->getRequest()
                        ->getParam('report_id')
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
        if ($id = $this->getRequest()->getParam('report_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('gpec_report/report');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gpec_report')->__('The job has been deleted.'));
                // go to grid
                Mage::dispatchEvent('gpec_report_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'success'
                    ));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('gpec_report_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'fail'
                    ));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array(
                    'report_id' => $id
                ));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gpec_report')->__('Unable to find a job to delete.'));
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
        $this->_initReport();
        $this->loadLayout();
        $this->getLayout()->getBlock('user.grid')
            ->setUserIds($this->getRequest()->getPost('user_ids'));
        $this->renderLayout();
    }

    public function usergridAction()
    {
        $this->_initReport();
        $this->loadLayout();
        $this->getLayout()->getBlock('user.grid')
            ->setUserIds($this->getRequest()->getPost('user_ids'));
        $this->renderLayout();
    }

    /**
     * Upload
     */
    protected function _uploadFile($model)
    {
        $data = array();

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Gpec_Report_Model_Report::REPORT_DIRECTORY;

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_report')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Gpec_Report_Model_Report::REPORT_DIRECTORY . 'SUIVI';

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_report')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Gpec_Report_Model_Report::REPORT_DIRECTORY . 'EDP';

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_report')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Gpec_Report_Model_Report::REPORT_DIRECTORY;

        /* File path 1  */
        if (isset($_FILES['file_path_1']['name']) && (file_exists($_FILES['file_path_1']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('file_path_1');
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

                $uploader->save($dirPath . DS . $model->getType($model->getTypeId()), $_FILES['file_path_1']['name']);
                $data['file_path_1'] = Gpec_Report_Model_Report::REPORT_DIRECTORY . $model->getType($model->getTypeId()) . DS . $uploader->getUploadedFileName();
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $model->unsetData('file_path_1');
        }

        if ($imagePost = $this->getRequest()->getPost('file_path_1')) {
            if (isset($imagePost['delete']) && $imagePost['delete'] == 1) {
                $data['file_path_1'] = '';
            }
        }


        /* File path 2  */
        if (isset($_FILES['file_path_2']['name']) && (file_exists($_FILES['file_path_2']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('file_path_2');
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

                $uploader->save($dirPath . DS . $model->getType($model->getTypeId()), $_FILES['file_path_2']['name']);
                $data['file_path_2'] = Gpec_Report_Model_Report::REPORT_DIRECTORY . $model->getType($model->getTypeId()) . DS . $uploader->getUploadedFileName();
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $model->unsetData('file_path_2');
        }

        if ($imagePost = $this->getRequest()->getPost('file_path_2')) {
            if (isset($imagePost['delete']) && $imagePost['delete'] == 1) {
                $data['file_path_2'] = '';
            }
        }


        /* File path 3  */
        if (isset($_FILES['file_path_3']['name']) && (file_exists($_FILES['file_path_3']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('file_path_3');
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

                $uploader->save($dirPath . DS . $model->getType($model->getTypeId()), $_FILES['file_path_3']['name']);
                $data['file_path_3'] = Gpec_Report_Model_Report::REPORT_DIRECTORY . $model->getType($model->getTypeId()) . DS . $uploader->getUploadedFileName();
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $model->unsetData('file_path_3');
        }

        if ($imagePost = $this->getRequest()->getPost('file_path_3')) {
            if (isset($imagePost['delete']) && $imagePost['delete'] == 1) {
                $data['file_path_3'] = '';
            }
        }

        $model->addData($data);

        return $model;
    }
}
