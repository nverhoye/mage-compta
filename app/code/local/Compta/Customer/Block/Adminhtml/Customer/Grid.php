<?php

/**
 * Adminhtml customers grid
 *
 * @category   Compta
 * @package    Compta_customer
 * @author     Compta <contact@compta.fr>
 */
class Compta_Customer_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('customerGrid');
        $this->setDefaultSort('amount_invoiced');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('compta_customer/customer')->getCollection();

        /* @var $collection Compta_Customer_Model_Resource_Customer_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();


        $this->addColumn('customer_id',
            array(
                'header' => Mage::helper('compta_customer')->__('Id'),
                'align' => 'left',
                'index' => 'customer_id',
                'width' => '50px',
            ));

        $this->addColumn('nom',
            array(
                'header' => Mage::helper('compta_customer')->__('Nom'),
                'align' => 'left',
                'index' => 'nom'
            ));


        $this->addColumn('street',
            array(
                'header' => Mage::helper('compta_customer')->__('Rue'),
                'align' => 'left',
                'index' => 'street'
            ));

        $this->addColumn('postcode',
            array(
                'header' => Mage::helper('compta_customer')->__('Code postal'),
                'align' => 'left',
                'index' => 'postcode'
            ));


        $this->addColumn('city',
            array(
                'header' => Mage::helper('compta_customer')->__('Ville'),
                'align' => 'left',
                'index' => 'city'
            ));

        $this->addColumn('phone',
            array(
                'header' => Mage::helper('compta_customer')->__('Téléphone'),
                'align' => 'left',
                'index' => 'phone'
            ));

        $this->addColumn('email',
            array(
                'header' => Mage::helper('compta_customer')->__('Email'),
                'align' => 'left',
                'index' => 'email'
            ));



        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'customer_id' => $row->getId()
        ));
    }
}
