<?php

/**
 * Admin Job
 *
 * @category   Gpec
 * @package    Gpec_training
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Training_Block_Adminhtml_Training_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Initialize job edit block
     *
     * @return void
     */
    public function __construct()
    {
        $this->_objectId = 'training_id';
        $this->_controller = 'adminhtml_training';
        $this->_blockGroup = 'gpec_training';
        
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('gpec_training')->__('Save'));
        $this->_addButton('saveandcontinue',
                array(
                        'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                        'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                        'class' => 'save'
                ), - 100);

        $this->_formScripts[] = 'function saveAndContinueEdit() {
        editForm.submit($(\'edit_form\').action + \'back/edit/\');}';


        $this->_updateButton('delete', 'label', Mage::helper('gpec_training')->__('Delete'));

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
     * Retrieve text for header element depending on loaded job
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_training')->getId()) {
            return Mage::helper('gpec_training')->__("Modifier la formation '%s'", $this->htmlEscape(Mage::registry('current_training')->getName()));
        } else {
            return Mage::helper('gpec_training')->__("Saisie d'une nouvelle formation");
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
