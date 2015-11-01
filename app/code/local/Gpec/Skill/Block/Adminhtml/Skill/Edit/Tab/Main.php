<?php

/**
 * Skill edit form main tab
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        /* @var $model Gpec_Skill_Model_Skill */
        $model = Mage::registry('current_skill');
        
        /*
         * Checking if user have permissions to save information
         */
         $isElementDisabled = false;

        
        $form = new Varien_Data_Form();
        
        $form->setHtmlIdPrefix('skill_');
        
        $fieldset = $form->addFieldset('base_fieldset', array(
                'legend' => Mage::helper('gpec_skill')->__('Information')
        ));
        
        if ($model->getSkillId()) {
            $fieldset->addField('skill_id', 'hidden', array(
                    'name' => 'skill_id'
            ));
        }


        $fieldset->addField('category', 'text',
            array(
                'name' => 'category',
                'label' => Mage::helper('gpec_skill')->__('Catégorie'),
                'title' => Mage::helper('gpec_skill')->__('Catégorie'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('name', 'text', 
                array(
                        'name' => 'name',
                        'label' => Mage::helper('gpec_skill')->__('Nom'),
                        'title' => Mage::helper('gpec_skill')->__('Nom'),
                        'required' => true,
                        'disabled' => $isElementDisabled
                ));

        $fieldset->addField('description', 'textarea', 
                array(
                        'label' => Mage::helper('gpec_skill')->__('Description'),
                        'title' => Mage::helper('gpec_skill')->__('Description'),
                        'name' => 'description',
                        'disabled' => $isElementDisabled
                ));

        
        Mage::dispatchEvent('gpec_skill_adminhtml_skill_edit_tab_main_prepare_form', array(
                'form' => $form
        ));
        
        $form->setValues($model->getData());
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('gpec_skill')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('gpec_skill')->__('General');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
}
