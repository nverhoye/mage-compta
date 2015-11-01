<?php

/**
 * Manage invoices controller
 *
 * @category    Compta
 * @package     Compta_invoice
 * @author      Compta <contact@compta.fr>
 */
class Compta_Invoice_Adminhtml_Invoice_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Compta_invoice_Adminhtml_InvoiceController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('compta_invoice')
            ->_addBreadcrumb(Mage::helper('compta_invoice')->__('Invoice'), Mage::helper('compta_invoice')->__('Invoice'))
            ->_addBreadcrumb(Mage::helper('compta_invoice')->__('Manage Invoice'), Mage::helper('compta_invoice')->__('Manage Invoice'));
        return $this;
    }

    /**
     * Initialize invoice from request parameters
     *
     * @return Compta_invoice_Model_Invoice
     */
    protected function _initInvoice()
    {
        $id = (int)$this->getRequest()->getParam('invoice_id');
        $model = Mage::getModel('compta_invoice/invoice')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_invoice', $model);
        return $model;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Manage Invoice'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Invoice
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Invoice
     */
    public function editAction()
    {
        $model = $this->_initInvoice();
        $this->_title($model->getId() ? $model->getName() : $this->__('New Invoice'));

        $id = (int)$this->getRequest()->getParam('invoice_id');

        $this->_initAction($model)->_addBreadcrumb($id ? Mage::helper('compta_invoice')->__('Edit Invoice') : Mage::helper('compta_invoice')->__('New Invoice'),
            $id ? Mage::helper('compta_invoice')->__('Edit Invoice') : Mage::helper('compta_invoice')->__('New Invoice'));
        $this->renderLayout();
    }

    /**
     * Initialize invoice before saving
     */
    protected function _initInvoiceSave()
    {
        $invoice = $this->_initInvoice();
        $invoiceData = $this->getRequest()->getPost();
        if ($invoiceData) {
            $invoiceData = $this->_filterPostData($invoiceData);
        }

        // validating
        if (!$this->_validatePostData($invoiceData)) {
            $this->_redirect('*/*/edit', array(
                'invoice_id' => $model->getId(),
                '_current' => true
            ));
            return;
        }


        $invoice->addData($invoiceData);


        Mage::dispatchEvent('compta_invoice_prepare_save',
            array(
                'invoice' => $invoice,
                'request' => $this->getRequest()
            ));

        return $invoice;
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $model = $this->_initInvoiceSave();

            // try to save it
            try {

                $model = $this->_uploadFile($model);

                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('compta_invoice')->__('The invoice has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit',
                        array(
                            'invoice_id' => $model->getId(),
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
                $this->_getSession()->addException($e, Mage::helper('compta_invoice')->__('An error occurred while saving the invoice.' . $e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit',
                array(
                    'invoice_id' => $this->getRequest()
                        ->getParam('invoice_id')
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
        if ($id = $this->getRequest()->getParam('invoice_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('compta_invoice/invoice');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('compta_invoice')->__('The invoice has been deleted.'));
                // go to grid
                Mage::dispatchEvent('compta_invoice_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'success'
                    ));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('compta_invoice_on_delete',
                    array(
                        'name' => $name,
                        'status' => 'fail'
                    ));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array(
                    'invoice_id' => $id
                ));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('compta_invoice')->__('Unable to find a invoice to delete.'));
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
        $this->_initInvoice();
        $this->loadLayout();
        $this->getLayout()->getBlock('user.grid')
            ->setUserIds($this->getRequest()->getPost('user_ids'));
        $this->renderLayout();
    }

    public function usergridAction()
    {
        $this->_initInvoice();
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

        $dirPath = Mage::getConfig()->getOptions()->getMediaDir() . DS . Compta_Invoice_Model_Invoice::INVOICE_DIRECTORY;

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                Mage::throwException(Mage::helper('atecna_invoice')->__('Unable to create directory "%s".', $dirPath));
            }
        }


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
                $data['file_path_1'] = Compta_Invoice_Model_Invoice::INVOICE_DIRECTORY  . $uploader->getUploadedFileName();
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

        $model->addData($data);

        return $model;
    }
}
