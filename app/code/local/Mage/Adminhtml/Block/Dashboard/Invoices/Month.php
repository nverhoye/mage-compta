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
class Mage_Adminhtml_Block_Dashboard_Invoices_Month extends Mage_Adminhtml_Block_Dashboard_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('lastMonthGrid');
    }

    protected function _prepareCollection()
    {

        $collection = new Varien_Data_Collection();

        $monthsTrad = array(
            'January' => 'Janvier',
            'Fabruary' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        );


        for ($m = 0; $m < 5; $m++) {

            $object = new Varien_Object();

            $collectionInvoices = Mage::getModel('compta_invoice/invoice')->getCollection()
                ->addFieldToFilter('adjusted', 1)
                ->addFieldToFilter('payment_date', array('like' => date("Y-m", strtotime("-$m month")) . "-%"));

            $total = 0;
            foreach ($collectionInvoices as $invoice) {
                $total += $invoice->getAmount();
            }

            $object->setData('month', $monthsTrad[date("F", strtotime("-$m month"))] . ' ' . date("Y", strtotime("-$m month")));
            $object->setData('amount', $total);
            $object->setData('amount_net', Mage::helper('compta_invoice')->toNet($total));


            $collection->addItem($object);
            unset($object);
        }

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

        $this->addColumn('month',
            array(
                'header' => Mage::helper('compta_invoice')->__('Mois'),
                'align' => 'left',
                'index' => 'month'
            ));


        $this->addColumn('amount',
            array(
                'header' => Mage::helper('compta_invoice')->__('Montant BRUT'),
                'align' => 'left',
                'index' => 'amount',
                'renderer' => 'Compta_Invoice_Block_Adminhtml_Renderer_Amount'
            ));

        $this->addColumn('amount_net',
            array(
                'header' => Mage::helper('compta_invoice')->__('Montant NET'),
                'align' => 'left',
                'index' => 'amount_net',
                'renderer' => 'Compta_Invoice_Block_Adminhtml_Renderer_Amount'
            ));


        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);

        return parent::_prepareColumns();
    }

}
