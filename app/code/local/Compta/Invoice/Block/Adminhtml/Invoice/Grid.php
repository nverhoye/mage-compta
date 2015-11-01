<?php

/**
 * Adminhtml invoices grid
 *
 * @category   Compta
 * @package    Compta_invoice
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Invoice_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected $_countTotals = true;

    public function getTotals()
    {
        $totals = new Varien_Object();
        $fields = array(
            'amount' => 0,
        );
        foreach ($this->getCollection() as $item) {
            foreach($fields as $field=>$value){
                $fields[$field]+=$item->getData($field);
            }
        }
        //First column in the grid
        $fields['number']='Totals';
        $totals->setData($fields);
        return $totals;
    }

    public function __construct()
    {
        parent::__construct();
        $this->setId('invoiceGrid');
        $this->setDefaultSort('invoice_date');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('compta_invoice/invoice')->getCollection()
            ->addFieldToSelect('*');
            //->addFieldToSelect('nom as customer_name');

        $collection->getSelect()
            ->joinLeft('compta_customer', 'compta_customer.customer_id = main_table.customer_id');

        /* @var $collection Compta_Invoice_Model_Resource_Invoice_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('number',
            array(
                'header' => Mage::helper('compta_invoice')->__('Numéro'),
                'align' => 'left',
                'index' => 'number'
            ));


        $this->addColumn('nom',
            array(
                'header' => Mage::helper('compta_invoice')->__('Client'),
                'align' => 'left',
                'index' => 'nom',
                'type'      => 'options',
                'options' => Mage::helper('compta_customer')->getCustomers(true)
            ));

        $this->addColumn('amount',
            array(
                'header' => Mage::helper('compta_invoice')->__('Montant'),
                'align' => 'left',
                'index' => 'amount',
                'renderer' => 'Compta_Invoice_Block_Adminhtml_Renderer_Amount'
            ));


        $this->addColumn('invoice_date',
            array(
                'header' => Mage::helper('compta_invoice')->__("Date d'émission"),
                'index' => 'invoice_date',
                'type' => 'date'
            ));

        $this->addColumn('payment_limit',
            array(
                'header' => Mage::helper('compta_invoice')->__('Date limite'),
                'index' => 'payment_limit',
                'type' => 'date'
            ));

        $this->addColumn('payment_date',
            array(
                'header' => Mage::helper('compta_invoice')->__('Date de paiement'),
                'index' => 'payment_date',
                'type' => 'date'
            ));


        $this->addColumn('quarter',
            array(
                'header' => Mage::helper('compta_invoice')->__('Trimestre'),
                'align' => 'left',
                'index' => 'quarter',
                'type'      => 'options',
                'options' => Mage::helper('compta_invoice')->getQuarters(true)
            ));

        $this->addColumn('adjusted',
            array(
                'header' => Mage::helper('compta_invoice')->__('Réglé'),
                'align' => 'left',
                'index' => 'adjusted',
                'renderer' => 'Compta_Invoice_Block_Adminhtml_Renderer_Adjusted',
                'type'      => 'options',
                'options'   => array(
                    '0' => 'Non',
                    '1' => 'Oui'
                ),
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
            'invoice_id' => $row->getId()
        ));
    }
}
