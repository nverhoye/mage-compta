<?php

/**
 * Job edit form main tab
 *
 * @category   Gpec
 * @package    Gpec_report
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Report_Block_Adminhtml_Report_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        /* @var $model Gpec_report_Model_Job */
        $model = Mage::registry('current_report');

        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = false;


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('report_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('gpec_report')->__('Information')
        ));

        if ($model->getReportId()) {
            $fieldset->addField('report_id', 'hidden', array(
                'name' => 'report_id'
            ));
        }

        $fieldset->addField('type_id', 'select', array(
            'name' => 'type_id',
            'label' => Mage::helper('adminhtml')->__('Type'),
            'id' => 'type_id',
            'title' => Mage::helper('adminhtml')->__('Type'),
            'values' => Mage::getModel('gpec_report/report')->getTypes(),
            'required' => false,
        ));


        $fieldset->addField('author_id', 'select',
            array(
                'name' => 'author_id',
                'label' => Mage::helper('gpec_report')->__('Auteur'),
                'title' => Mage::helper('gpec_report')->__('Auteur'),
                'required' => true,
                'values' => Mage::helper('gpec_user')->getOptions(),
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('user_id', 'select',
            array(
                'name' => 'user_id',
                'label' => Mage::helper('gpec_report')->__('Assigné à'),
                'title' => Mage::helper('gpec_report')->__('Assigné à'),
                'required' => true,
                'values' => Mage::helper('gpec_user')->getOptions(),
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('name', 'text',
            array(
                'name' => 'name',
                'label' => Mage::helper('gpec_report')->__('Nom du rapport'),
                'title' => Mage::helper('gpec_report')->__('Nom du rapport'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('content', 'textarea',
            array(
                'label' => Mage::helper('gpec_report')->__('Contenu'),
                'title' => Mage::helper('gpec_report')->__('Contenu'),
                'name' => 'content',
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('file_path_1', 'file',
            array(
                'label' => Mage::helper('gpec_report')->__('Fichier 1'),
                'title' => Mage::helper('gpec_report')->__('Fichier 1'),
                'name' => 'file_path_1',
                'disabled' => $isElementDisabled
            ));


        if ($model->getFilePath_1()) {
            $fieldset->addField('note_1', 'note', array(
                'text' =>
                    '<a href="' . Mage::getBaseUrl('media') . $model->getFilePath_1() . '">' . $model->getFilePath_1() . '</a>',
            ));
        }

        $fieldset->addField('file_path_2', 'file',
            array(
                'label' => Mage::helper('gpec_report')->__('Fichier 2'),
                'title' => Mage::helper('gpec_report')->__('Fichier 2'),
                'name' => 'file_path_2',
                'disabled' => $isElementDisabled
            ));


        if ($model->getFilePath_2()) {
            $fieldset->addField('note_2', 'note', array(
                'text' =>
                    '<a href="' . Mage::getBaseUrl('media') . $model->getFilePath_2() . '">' . $model->getFilePath_2() . '</a>',
            ));
        }
        $fieldset->addField('file_path_3', 'file',
            array(
                'label' => Mage::helper('gpec_report')->__('Fichier 3'),
                'title' => Mage::helper('gpec_report')->__('Fichier 3'),
                'name' => 'file_path_3',
                'disabled' => $isElementDisabled
            ));

        if ($model->getFilePath_3()) {
            $fieldset->addField('note_3', 'note', array(
                'text' =>
                    '<a href="' . Mage::getBaseUrl('media') . $model->getFilePath_3() . '">' . $model->getFilePath_3() . '</a>',
            ));
        }

        Mage::dispatchEvent('gpec_report_adminhtml_report_edit_tab_main_prepare_form', array(
            'form' => $form
        ));

        $model->setAuthorId(Mage::getSingleton('admin/session')->getUser()->getUserId());

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
        return Mage::helper('gpec_report')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('gpec_report')->__('General');
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
