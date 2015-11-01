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
 * Adminhtml dashboard helper for orders
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Helper_Dashboard_Order extends Mage_Adminhtml_Helper_Dashboard_Abstract
{

    protected function _initCollection()
    {
        /*
        $isFilter = $this->getParam('store') || $this->getParam('website') || $this->getParam('group');

        $this->_collection = Mage::getResourceSingleton('reports/order_collection')
            ->prepareSummary($this->getParam('period'), 0, 0, $isFilter);

        if ($this->getParam('store')) {
            $this->_collection->addFieldToFilter('store_id', $this->getParam('store'));
        } else if ($this->getParam('website')){
            $storeIds = Mage::app()->getWebsite($this->getParam('website'))->getStoreIds();
            $this->_collection->addFieldToFilter('store_id', array('in' => implode(',', $storeIds)));
        } else if ($this->getParam('group')){
            $storeIds = Mage::app()->getGroup($this->getParam('group'))->getStoreIds();
            $this->_collection->addFieldToFilter('store_id', array('in' => implode(',', $storeIds)));
        } elseif (!$this->_collection->isLive()) {
            $this->_collection->addFieldToFilter('store_id',
                array('eq' => Mage::app()->getStore(Mage_Core_Model_Store::ADMIN_CODE)->getId())
            );
        }*/


      $this->_collection = Mage::getResourceSingleton('reports/order_collection')
            ->prepareSummary($this->getParam('period'), 0, 0, false);

        echo $this->_collection->getSelect(); die;

        $collection = Mage::getResourceSingleton('compta_invoice/invoice_collection');
        $collection->addFieldToSelect(new Zend_Db_Expr('SUM(amount) as revenue'));
        $collection->addFieldToSelect(new Zend_Db_Expr('COUNT(invoice_id) as quantity'));
        $collection->addFieldToSelect(new Zend_Db_Expr("CONCAT(DATE_FORMAT(DATE_ADD(`payment_date`, INTERVAL 7200 SECOND), '%Y-%m-%d %H:'), '00') AS `range`"));

       // $collection->addFieldToFilter(new Zend_Db_Expr('adjusted = 1'));
        $collection->addFieldToFilter('adjusted','1');

//        $collection->addFieldToFilter(new Zend_Db_Expr('adjusted = 1'));


        $range = $this->getParam('period');

        $dateRange = Mage::getResourceSingleton('reports/order_collection')->getDateRange($range, 0, 0);
/*
        $tzRangeOffsetExpression = Mage::getResourceSingleton('reports/order_collection')->_getTZRangeOffsetExpression(
            $range, 'payment_date', $dateRange['from'], $dateRange['to']
        );
*/
        $collection->getSelect()
            ->order('range', Zend_Db_Select::SQL_ASC)
            ->group(new Zend_Db_Expr("CONCAT(DATE_FORMAT(DATE_ADD(`payment_date`, INTERVAL 7200 SECOND), '%Y-%m-%d %H:'), '00')"));

        $collection->addFieldToFilter('payment_date', $dateRange);




      //  echo $collection->getSelect(); die;
/*

        WHERE (main_table.state NOT IN ('pending_payment', 'new'))
        AND (created_at >= '2015-09-19 22:10:47' AND created_at <= '2015-09-20 22:10:47')
        GROUP BY CONCAT(DATE_FORMAT(DATE_ADD(`created_at`, INTERVAL 7200 SECOND), '%Y-%m-%d %H:'), '00')
        ORDER BY `range` ASC
        */
        $this->_collection = $collection;

        $this->_collection->load();
    }

}
