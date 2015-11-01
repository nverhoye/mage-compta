<?php

/**
 * Adminhtml skill content
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_User_Block_Adminhtml_Renderer_Fullname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $userId = $row->getData($this->getColumn()->getIndex());
        $user = Mage::getModel('admin/user')->load($userId);
        return $user->getFirstname().' '.$user->getLastname();
    }


}