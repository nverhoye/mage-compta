<?php

/**
 * Adminhtml job edit form block
 *
 * @category   Gpec
 * @package    Gpec_training
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Training_Block_Adminhtml_Training_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
                array(
                        'id' => 'edit_form',
                        'action' => $this->getData('action'),
                        'method' => 'post',
                        'enctype' => 'multipart/form-data'
                ));
        
        $form->setUseContainer(true);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
}
