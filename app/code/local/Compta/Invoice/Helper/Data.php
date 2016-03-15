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
 * @package     Mage_AdminNotification
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Compta_Invoice_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getQuarters($header = false)
    {
        for ($y = (date('Y') - 1); $y <= date('Y'); $y++) {
            for ($t = 1; $t <= 4; $t++) {
                $quarters[$y . '-' . $t] = $y . '-' . $t;
            }
        }
        krsort($quarters);

        if(!$header) {
            $quarters = array_merge(array('' => 'Sélectionner'), $quarters);
        }

        return $quarters;
    }

    public function toNet($amount)
    {
        //$tax = '22.9';
        $tax = 50;
        $net = ($amount / (1 + ($tax/100)));
        return round($net);
    }


    public function getNextDateDeclaration()
    {

        $moisEnCours = date("m");

        $moisDecl = array(
          '3',
          '6',
          '9',
          '12'
        );

        $moisDeclFinal = array();
        foreach($moisDecl as $md) {
            if($moisEnCours <= $md) {
                $moisDeclFinal[] = date("Y-m-d", mktime(0,0,0,$md+1,0,date("Y")));
            }
        }

        return $moisDeclFinal[0];

    }

    public function getDaysUntilNextDeclaration()
    {
        $date = $this->getNextDateDeclaration();

        $your_date = strtotime($date);
        $datediff = strtotime(date('Y-m-d')) - $your_date;
        return abs(floor($datediff/(60*60*24)));

    }
}
