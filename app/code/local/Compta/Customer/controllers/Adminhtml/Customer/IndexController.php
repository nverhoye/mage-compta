<?php

/**
 * Manage customers controller
 *
 * @category    Compta
 * @package     Compta_customer
 * @author      Compta <contact@compta.fr>
 */
class Compta_Customer_Adminhtml_Customer_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Compta_customer_Adminhtml_CustomerController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('compta_customer')
            ->_addBreadcrumb(Mage::helper('compta_customer')->__('Customer'), Mage::helper('compta_customer')->__('Customer'))
            ->_addBreadcrumb(Mage::helper('compta_customer')->__('Manage Customer'), Mage::helper('compta_customer')->__('Manage Customer'));
        return $this;
    }

    /**
     * Initialize customer from request parameters
     *
     * @return Compta_customer_Model_Customer
     */
    protected function _initCustomer()
    {
        $id = (int)$this->getRequest()->getParam('customer_id');
        $model = Mage::getModel('compta_customer/customer')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_customer', $model);
        return $model;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Manage Customer'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Customer
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Customer
     */
    public function editAction()
    {
        $model = $this->_initCustomer();
        $this->_title($model->getId() ? $model->getName() : $this->__('New Customer'));

        $id = (int)$this->getRequest()->getParam('customer_id');

        $this->_initAction($model)->_addBreadcrumb($id ? Mage::helper('compta_customer')->__('Edit Customer') : Mage::helper('compta_customer')->__('New Customer'),
            $id ? Mage::helper('compta_customer')->__('Edit Customer') : Mage::helper('compta_customer')->__('New Customer'));
        $this->renderLayout();
    }

    /**
     * Initialize customer before saving
     */
    protected function _initCustomerSave()
    {
        $customer = $this->_initCustomer();
        $customerData = $this->getRequest()->getPost();
        if ($customerData) {
            $customerData = $this->_filterPostData($customerData);
        }

        // validating
        if (!$this->_validatePostData($customerData)) {
            $this->_redirect('*/*/edit', array(
                'customer_id' => $model->getId(),
                '_current' => true
            ));
            return;
        }

        $customer->addData($customerData);


        Mage::dispatchEvent('compta_customer_prepare_save',
            array(
                'customer' => $customer,
                'request' => $this->getRequest()
            ));

        return $customer;
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $model = $this->_initCustomerSave();

            // try to save it
            try {

                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('compta_customer')->__('The customer has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit',
                        array(
                            'customer_id' => $model->getId(),
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
                $this->_getSession()->addException($e, Mage::helper('compta_customer')->__('An error occurred while saving the customer.' . $e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit',
                array(
                    'customer_id' => $this->getRequest()
                        ->getParam('customer_id')
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
        if ($id = $this->getRequest()->getParam('customer_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('compta_customer/customer');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('compta_customer')->__('The customer has been deleted.'));
                // go to grid
                Mage::dispatchEvent('compta_customer_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'success'
                    ));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('compta_customer_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'fail'
                    ));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array(
                    'customer_id' => $id
                ));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('compta_customer')->__('Unable to find a customer to delete.'));
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
        $this->_initCustomer();
        $this->loadLayout();
        $this->getLayout()->getBlock('user.grid')
            ->setUserIds($this->getRequest()->getPost('user_ids'));
        $this->renderLayout();
    }

    public function usergridAction()
    {
        $this->_initCustomer();
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

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Compta_Customer_Model_Customer::REPORT_DIRECTORY;

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_customer')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Compta_Customer_Model_Customer::REPORT_DIRECTORY . 'SUIVI';

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_customer')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Compta_Customer_Model_Customer::REPORT_DIRECTORY . 'EDP';

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_customer')->__('Unable to create directory "%s".', $dirPath));
            }
        }

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Compta_Customer_Model_Customer::REPORT_DIRECTORY;

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
                $data['file_path_1'] = Compta_Customer_Model_Customer::REPORT_DIRECTORY . $model->getType($model->getTypeId()) . DS . $uploader->getUploadedFileName();
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
                $data['file_path_2'] = Compta_Customer_Model_Customer::REPORT_DIRECTORY . $model->getType($model->getTypeId()) . DS . $uploader->getUploadedFileName();
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
                $data['file_path_3'] = Compta_Customer_Model_Customer::REPORT_DIRECTORY . $model->getType($model->getTypeId()) . DS . $uploader->getUploadedFileName();
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
