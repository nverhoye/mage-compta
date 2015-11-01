<?php

/**
 * Manage jobs controller
 *
 * @category    Gpec
 * @package     Gpec_Job
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Core_Adminhtml_Gpec_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Gpec_Job_Adminhtml_JobController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('gpec_core')
            ->_addBreadcrumb(Mage::helper('gpec_core')->__('Recherche'), Mage::helper('gpec_core')->__('Recherche'));
        return $this;
    }

    public function indexAction()
    {
        $this->loadLayout();

        $this->_initAction();
        $this->renderLayout();
    }

    public function getAction()
    {
        $q = $this->getRequest()->getParam('query');
        $this->loadLayout();
        $this->getLayout()->getBlock('result')->setQuery($q);
        $this->renderLayout();
    }

}
