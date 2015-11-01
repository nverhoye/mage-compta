<?php

/**
 * Adminhtml skill content
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Report_Block_Adminhtml_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $url = Mage::helper('adminhtml')->getUrl('*/report_index/edit', array('report_id' => $row->getData('report_id')));
        return '<a href="'.$url.'">Consulter</a>';
    }


}