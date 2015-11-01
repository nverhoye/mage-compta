<?php

/**
 * Invoice edit form main tab
 *
 * @category   Compta
 * @package    Compta_invoice
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Invoice_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        /* @var $model Compta_invoice_Model_Invoice */
        $model = Mage::registry('current_invoice');

        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = false;


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('invoice_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('compta_invoice')->__('Information')
        ));

        if ($model->getInvoiceId()) {
            $fieldset->addField('invoice_id', 'hidden', array(
                'name' => 'invoice_id'
            ));
        }

        $fieldset->addField('customer_id', 'select', array(
            'name' => 'customer_id',
            'label' => Mage::helper('adminhtml')->__('Client'),
            'title' => Mage::helper('adminhtml')->__('Client'),
            'id' => 'customer_id',
            'values' => Mage::helper('compta_customer')->getCustomers(),
            'required' => true,
        ));


        $fieldset->addField('number', 'text',
            array(
                'name' => 'number',
                'label' => Mage::helper('compta_invoice')->__('Numéro de facture'),
                'title' => Mage::helper('compta_invoice')->__('Numéro de facture'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('amount', 'text',
            array(
                'name' => 'amount',
                'label' => Mage::helper('compta_invoice')->__('Montant'),
                'title' => Mage::helper('compta_invoice')->__('Montant'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('invoice_date', 'date', array(
            'name'               => 'invoice_date',
            'label'              => Mage::helper('compta_invoice')->__("Date d'émission"),
            'tabindex'           => 1,
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image'              => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                strtotime('next weekday') )
        ));


        $fieldset->addField('payment_limit', 'date', array(
            'name'               => 'payment_limit',
            'label'              => Mage::helper('compta_invoice')->__('Date limite de paiement'),
            'tabindex'           => 2,
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image'              => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                strtotime('next weekday') )
        ));

        $fieldset->addField('payment_date', 'date', array(
            'name'               => 'payment_date',
            'label'              => Mage::helper('compta_invoice')->__('Date de paiement'),
            'tabindex'           => 3,
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'image'              => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                strtotime('next weekday') )
        ));


        $fieldset->addField('quarter', 'select',
            array(
                'name' => 'quarter',
                'label' => Mage::helper('compta_invoice')->__('Trimestre'),
                'title' => Mage::helper('compta_invoice')->__('Trimestre'),
                'required' => false,
                'values' => Mage::helper('compta_invoice')->getQuarters(),
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('adjusted', 'select',
            array(
                'name' => 'adjusted',
                'label' => Mage::helper('compta_invoice')->__('Payé'),
                'title' => Mage::helper('compta_invoice')->__('Payé'),
                'values' => array(
                    '0' => 'Non',
                    '1' => 'Oui',
                ),
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('comment', 'textarea',
            array(
                'label' => Mage::helper('compta_invoice')->__('Commentaire'),
                'title' => Mage::helper('compta_invoice')->__('Commentaire'),
                'name' => 'comment',
                'style' => 'height:50px',
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('file_path_1', 'file',
            array(
                'label' => Mage::helper('compta_invoice')->__('Fichier'),
                'title' => Mage::helper('compta_invoice')->__('Fichier'),
                'name' => 'file_path_1',
                'disabled' => $isElementDisabled
            ));


        if ($model->getFilePath_1()) {
            $fieldset->addField('note_1', 'note', array(
                'text' =>
                    '<a href="' . Mage::getBaseUrl('media') . $model->getFilePath_1() . '">' . $model->getFilePath_1() . '</a>',
            ));
        }


        Mage::dispatchEvent('compta_invoice_adminhtml_invoice_edit_tab_main_prepare_form', array(
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
        return Mage::helper('compta_invoice')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('compta_invoice')->__('General');
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
