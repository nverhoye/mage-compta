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
 * Adminhtml dashboard totals bar
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Dashboard_Totals extends Mage_Adminhtml_Block_Dashboard_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('lastOrdersGrid');
    }


    protected function _prepareCollection()
    {

        $collection = new Varien_Data_Collection();

        $monthsTrad = array(
            '1' => 'Janvier',
            '2' => 'Février',
            '3' => 'Mars',
            '4' => 'Avril',
            '5' => 'Mai',
            '6' => 'Juin',
            '7' => 'Juillet',
            '8' => 'Août',
            '9' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        );

        $tab = array();

        $calendarCollection = Mage::getModel('compta_calendar/calendar')->getCollection();

        foreach ($calendarCollection as $calendar) {
            $dateValues = Mage::helper('core')->jsonDecode($calendar->getValues());
            foreach ($dateValues as $day => $nhour) {
                $customer = Mage::getModel('compta_customer/customer')->load($calendar->getCustomerId());

                $delayPaiement = $customer->getPaiementDelay();
                $yyyy_mm = substr($day, 0, 7);


                if(!isset($tab[$yyyy_mm][$calendar->getCustomerId()]['nbhour'])) {
                    $tab[$yyyy_mm][$calendar->getCustomerId()]['nbhour'] = 0;
                }
                $tab[$yyyy_mm][$calendar->getCustomerId()]['nbhour']+=$nhour;
                $tab[$yyyy_mm][$calendar->getCustomerId()]['delay'] = $delayPaiement;


            }
        }

        $prevision = array();

        foreach($tab as $monthYYYYmm => $customerId) {

            foreach($customerId as $cId => $data) {

                $addDay = $data['delay'] ? $data['delay'] : "0";

                $nextMonthDate = date('Y-m', strtotime("+1 months +$addDay days", strtotime($monthYYYYmm . '-01')));
                $customer = Mage::getModel('compta_customer/customer')->load($calendar->getCustomerId());


                if(!isset($prevision[$nextMonthDate])) {
                    $prevision[$nextMonthDate] = 0;
                }
                $prevision[$nextMonthDate] += ($customer->getThm() * $data['nbhour']);
            }


        }

        $currentMonth = (int)(date('m'));

        for ($m = $currentMonth; $m <= ($currentMonth + 5); $m++) {


            $findMe = (date('Y') . '-' . (sprintf("%'.02d", $m)));

            $object = new Varien_Object();

            if(!isset($prevision[$findMe])) {
                $total = 0;
            } else {
                $total = $prevision[$findMe];
            }

            $object->setData('month', $monthsTrad[$m]);
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
