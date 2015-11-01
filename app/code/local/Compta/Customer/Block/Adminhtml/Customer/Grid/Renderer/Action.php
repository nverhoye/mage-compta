<?php

/**
 * @category   Compta
 * @package    Compta_customer
 * @author     Compta <contact@compta.fr>
 */
class Compta_Customer_Block_Adminhtml_Customer_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $href = $this->getUrl('*/*/edit', array(
                'customer_id' => $row->getId()
        ));
        return '<a href="' . $href . '">' . $this->__('Edit') . '</a>';
    }
}
