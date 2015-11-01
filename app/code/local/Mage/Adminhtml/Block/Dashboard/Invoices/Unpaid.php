<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml dashboard recent orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Adminhtml_Block_Dashboard_Invoices_Unpaid extends Mage_Adminhtml_Block_Dashboard_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('lastInvoicesGrid');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('compta_invoice/invoice')->getCollection()
            ->addFieldToFilter('adjusted', 0)
            ->addFieldToSelect('*');

        $collection->getSelect()
            ->joinLeft('compta_customer', 'compta_customer.customer_id = main_table.customer_id');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepares page sizes for dashboard grid with las 5 orders
     *
     * @return void
     */
    protected function _preparePage()
    {
        $this->getCollection()->setPageSize($this->getParam($this->getVarNameLimit(), $this->_defaultLimit));
        // Remove count of total orders $this->getCollection()->setCurPage($this->getParam($this->getVarNamePage(), $this->_defaultPage));
    }

    protected function _prepareColumns()
    {

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
                'index' => 'nom'
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


        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/invoice_index/edit', array('invoice_id'=>$row->getId()));
    }
}
