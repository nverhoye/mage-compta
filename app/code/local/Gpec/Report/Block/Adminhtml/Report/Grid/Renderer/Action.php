<?php

/**
 * @category   Gpec
 * @package    Gpec_report
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Report_Block_Adminhtml_Report_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $href = $this->getUrl('*/*/edit', array(
                'report_id' => $row->getId()
        ));
        return '<a href="' . $href . '">' . $this->__('Edit') . '</a>';
    }
}
