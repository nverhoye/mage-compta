<?php

/**
 * Job edit form main tab
 *
 * @category   Gpec
 * @package    Gpec_Job
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Job_Block_Adminhtml_Job_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        /* @var $model Gpec_Job_Model_Job */
        $model = Mage::registry('current_job');

        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = false;


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('job_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('gpec_job')->__('Information')
        ));

        if ($model->getJobId()) {
            $fieldset->addField('job_id', 'hidden', array(
                'name' => 'job_id'
            ));
        }

        $fieldset->addField('name', 'text',
            array(
                'name' => 'name',
                'label' => Mage::helper('gpec_job')->__('Nom du poste'),
                'title' => Mage::helper('gpec_job')->__('Nom du poste'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('description', 'textarea',
            array(
                'label' => Mage::helper('gpec_job')->__('Description'),
                'title' => Mage::helper('gpec_job')->__('Description'),
                'name' => 'description',
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('file_path', 'file',
            array(
                'label' => Mage::helper('gpec_job')->__('Fiche de poste'),
                'title' => Mage::helper('gpec_job')->__('Fiche de poste'),
                'name' => 'file_path',
                'disabled' => $isElementDisabled,
                'src' => Gpec_Job_Model_Job::JOB_DIRECTORY,
            ));

        if($model->getFilePath()) {
            $fieldset->addField('note', 'note', array(
                'text'     =>
                    '<a href="'.Mage::getBaseUrl('media')  . $model->getFilePath().'">'.$model->getFilePath().'</a>',
            ));
        }

        Mage::dispatchEvent('gpec_job_adminhtml_job_edit_tab_main_prepare_form', array(
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
        return Mage::helper('gpec_job')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('gpec_job')->__('General');
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
