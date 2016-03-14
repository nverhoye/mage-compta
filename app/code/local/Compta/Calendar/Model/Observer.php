<?php

class Compta_Calendar_Model_Observer extends Varien_Event_Observer
{
    public function __construct()
    {
    }

    public function setLocationQuoteAttribute($observer)
    {
        $item = $observer->getQuoteItem();
        $product = $observer->getProduct();
        if ($product->getLocation()) {
            $item->setIsLocation($product->getLocation());
            $lessPrice = Mage::helper('compta_calendar')->getLessPrixLocation($product);
            $item->setStartPrice($lessPrice);
            $price = 0;
            // Set the custom price
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            // Enable super mode on the product.
            $item->getProduct()->setIsSuperMode(true);
        }
    }
    
    public function checkProductColor($observer){
        
    }
}
