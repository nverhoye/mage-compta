<?php

/**
 * Adminhtml skill content
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_skill';
        $this->_blockGroup = 'gpec_skill';
        $this->_headerText = Mage::helper('gpec_skill')->__('Gestion des compétences');

        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('gpec_skill')->__('Créer une compétence'));

    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('skill/' . $action);
    }

}
