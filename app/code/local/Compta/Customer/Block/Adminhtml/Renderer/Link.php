<?php

/**
 * Adminhtml skill content
 *
 * @category   Compta
 * @package    Compta_Skill
 * @author     Compta <contact@compta.fr>
 */
class Compta_Customer_Block_Adminhtml_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $url = Mage::helper('adminhtml')->getUrl('*/customer_index/edit', array('customer_id' => $row->getData('customer_id')));
        return '<a href="'.$url.'">Consulter</a>';
    }


}