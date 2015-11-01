<?php

/**
 * Admin Skill
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Initialize skill edit block
     *
     * @return void
     */
    public function __construct()
    {

        $this->_objectId = 'skill_id';
        $this->_controller = 'adminhtml_skill';
        $this->_blockGroup = 'gpec_skill';
        
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('gpec_skill')->__('Save'));
        $this->_addButton('saveandcontinue',
                array(
                        'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                        'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                        'class' => 'save'
                ), - 100);

        $this->_formScripts[] = 'function saveAndContinueEdit() {
        editForm.submit($(\'edit_form\').action + \'back/edit/\');}';


        $this->_updateButton('delete', 'label', Mage::helper('gpec_skill')->__('Delete'));

    }

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }
        return $this->getUrl('*/*/save');
    }

    /**
     * Retrieve text for header element depending on loaded skill
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_skill')->getId()) {
            return Mage::helper('gpec_skill')->__("Modifier la compétence '%s'", $this->htmlEscape(Mage::registry('current_skill')->getName()));
        } else {
            return Mage::helper('gpec_skill')->__('Nouvelle compétence');
        }
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', 
                array(
                        '_current' => true,
                        'back' => 'edit',
                        'active_tab' => '{{tab_id}}'
                ));
    }

    /**
     * Prepare layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setCanLoadExtJs(true);
        }
        return parent::_prepareLayout();
    }
}
