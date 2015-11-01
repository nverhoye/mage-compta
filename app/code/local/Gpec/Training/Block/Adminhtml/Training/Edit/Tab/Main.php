<?php

/**
 * Job edit form main tab
 *
 * @category   Gpec
 * @package    Gpec_training
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Training_Block_Adminhtml_Training_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        /* @var $model Gpec_training_Model_Job */
        $model = Mage::registry('current_training');

        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = false;


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('training_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('gpec_training')->__('Information')
        ));

        if ($model->getTrainingId()) {
            $fieldset->addField('training_id', 'hidden', array(
                'name' => 'training_id'
            ));
        }

        $fieldset->addField('name', 'text',
            array(
                'name' => 'name',
                'label' => Mage::helper('gpec_training')->__('Nom de la formation'),
                'title' => Mage::helper('gpec_training')->__('Nom de la formation'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('trainer', 'text',
            array(
                'name' => 'trainer',
                'label' => Mage::helper('gpec_training')->__('Organisateur'),
                'title' => Mage::helper('gpec_training')->__('Organisateur'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('description', 'textarea',
            array(
                'label' => Mage::helper('gpec_training')->__('Description'),
                'title' => Mage::helper('gpec_training')->__('Description'),
                'name' => 'description',
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('started_at', 'date', array(
            'name'               => 'started_at',
            'label'              => Mage::helper('gpec_training')->__('Date de début'),
            'tabindex'           => 1,
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image'              => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                strtotime('next weekday') )
        ));
        $fieldset->addField('ended_at', 'date', array(
            'name'               => 'ended_at',
            'label'              => Mage::helper('gpec_training')->__('Date de fin'),
            'tabindex'           => 1,
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image'              => $this->getSkinUrl('images/grid-cal.gif'),
            'format'             => Varien_Date::DATE_INTERNAL_FORMAT,
            'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                strtotime('next weekday') )
        ));


        $fieldset->addField('file_path', 'file',
            array(
                'label' => Mage::helper('gpec_training')->__('Fiche'),
                'title' => Mage::helper('gpec_training')->__('Fiche'),
                'name' => 'file_path',
                'disabled' => $isElementDisabled
            ));

        if($model->getFilePath()) {
            $fieldset->addField('note', 'note', array(
                'text'     =>
                    '<a href="'.Mage::getBaseUrl('media')  . $model->getFilePath().'">'.$model->getFilePath().'</a>',
            ));
        }

        Mage::dispatchEvent('gpec_training_adminhtml_training_edit_tab_main_prepare_form', array(
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
        return Mage::helper('gpec_training')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('gpec_training')->__('General');
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
