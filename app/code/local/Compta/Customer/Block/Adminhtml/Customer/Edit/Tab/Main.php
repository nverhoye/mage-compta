<?php

/**
 * Customer edit form main tab
 *
 * @category   Compta
 * @package    Compta_customer
 * @author     Compta <contact@compta.fr>
 */
class Compta_Customer_Block_Adminhtml_Customer_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        /* @var $model Compta_customer_Model_Customer */
        $model = Mage::registry('current_customer');

        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = false;


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('customer_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('compta_customer')->__('Information')
        ));

        if ($model->getCustomerId()) {
            $fieldset->addField('customer_id', 'hidden', array(
                'name' => 'customer_id'
            ));
        }


        $fieldset->addField('nom', 'text',
            array(
                'name' => 'nom',
                'label' => Mage::helper('compta_customer')->__('Nom'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('street', 'text',
            array(
                'name' => 'street',
                'label' => Mage::helper('compta_customer')->__('Adresse'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));


        $fieldset->addField('city', 'text',
            array(
                'name' => 'city',
                'label' => Mage::helper('compta_customer')->__('Ville'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('postcode', 'text',
            array(
                'name' => 'postcode',
                'label' => Mage::helper('compta_customer')->__('Code postal'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('phone', 'text',
            array(
                'name' => 'phone',
                'label' => Mage::helper('compta_customer')->__('Téléphone'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));
        $fieldset->addField('email', 'text',
            array(
                'name' => 'email',
                'label' => Mage::helper('compta_customer')->__('Email'),
                'required' => true,
                'disabled' => $isElementDisabled
            ));


        $fieldset = $form->addFieldset('more_fieldset', array(
            'legend' => Mage::helper('compta_customer')->__('Complément')
        ));

        $fieldset->addField('thm', 'text',
            array(
                'name' => 'thm',
                'label' => Mage::helper('compta_customer')->__('Taux horaire HT'),
                'required' => false,
                'disabled' => $isElementDisabled
            ));

        $fieldset->addField('paiement_delay', 'text',
            array(
                'name' => 'paiement_delay',
                'label' => Mage::helper('compta_customer')->__('Délais de paiement (moyen)'),
                'required' => false,
                'disabled' => $isElementDisabled,
            ));

        $fieldset->addField('color', 'text',
            array(
                'name' => 'color',
                'label' => Mage::helper('compta_customer')->__('Couleur (calendrier)'),
                'required' => false,
                'disabled' => $isElementDisabled
            ));

        Mage::dispatchEvent('compta_customer_adminhtml_customer_edit_tab_main_prepare_form', array(
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
        return Mage::helper('compta_customer')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('compta_customer')->__('General');
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
