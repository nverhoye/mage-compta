<?php

/**
 * Adminhtml skill content
 *
 * @category   Compta
 * @package    Compta_Skill
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Renderer_Amount extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $data = $row->getData($this->getColumn()->getIndex());
        return Mage::helper('core')->currency($data, true, false);
    }


}