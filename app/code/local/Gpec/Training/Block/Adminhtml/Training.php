<?php

/**
 * Adminhtml job content
 *
 * @category   Gpec
 * @package    Gpec_training
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Training_Block_Adminhtml_Training extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_training';
        $this->_blockGroup = 'gpec_training';
        $this->_headerText = Mage::helper('gpec_training')->__('Gestion des formations');
        
        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('gpec_training')->__('Ajouter une formation'));

    }

    /**
     * Check permission for passed action
     *
     * @param string $action            
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('training/' . $action);
    }
}
