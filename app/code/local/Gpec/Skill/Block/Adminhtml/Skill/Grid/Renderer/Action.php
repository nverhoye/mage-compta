<?php

/**
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Skill_Block_Adminhtml_Skill_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $href = $this->getUrl('*/*/edit', array(
                'skill_id' => $row->getId()
        ));
        return '<a href="' . $href . '">' . $this->__('Edit') . '</a>';
    }
}
