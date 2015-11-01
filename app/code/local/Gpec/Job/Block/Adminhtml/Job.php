<?php

/**
 * Adminhtml job content
 *
 * @category   Gpec
 * @package    Gpec_Job
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Job_Block_Adminhtml_Job extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_job';
        $this->_blockGroup = 'gpec_job';
        $this->_headerText = Mage::helper('gpec_job')->__('Gestion des postes');
        
        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('gpec_job')->__('Créer un poste'));

    }

    /**
     * Check permission for passed action
     *
     * @param string $action            
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('job/' . $action);
    }
}
