<?php

class Gpec_User_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getOptions()
    {
        $optionsArr = array("Sélectionner une option");

        $collection = Mage::getModel('admin/user')->getCollection();
        $collection->getSelect()->order('firstname ASC');

        foreach ($collection as $user) {
            if($user->getId() == 8) continue;
            $optionsArr[$user->getId()] = $user->getFirstname() . ' ' . $user->getLastname();
        }

        return $optionsArr;
    }

    public function isAdminSuper()
    {
        return Mage::getSingleton('admin/session')->getUser()->getRoleName() == 'administrators';
    }

    public function isAdminManager()
    {
        return Mage::getSingleton('admin/session')->getUser()->getRoleName() == 'manager';
    }

    public function isAdminRh()
    {
        return Mage::getSingleton('admin/session')->getUser()->getRoleName() == 'rh';
    }

    public function isAdminCommerciaux()
    {
        return Mage::getSingleton('admin/session')->getUser()->getRoleName() == 'commerciaux';
    }
}
