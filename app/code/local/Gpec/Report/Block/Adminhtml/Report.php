<?php

/**
 * Adminhtml job content
 *
 * @category   Gpec
 * @package    Gpec_report
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Report_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_report';
        $this->_blockGroup = 'gpec_report';
        $this->_headerText = Mage::helper('gpec_report')->__('Gestion des rapports');
        
        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('gpec_report')->__('Ajouter un rapport'));

    }

    /**
     * Check permission for passed action
     *
     * @param string $action            
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('report/' . $action);
    }
}
