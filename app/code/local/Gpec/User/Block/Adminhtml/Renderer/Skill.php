<?php

/**
 * Adminhtml skill content
 *
 * @category   Gpec
 * @package    Gpec_Skill
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_User_Block_Adminhtml_Renderer_Skill extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Initialize block
     */
    public function __construct()
    {
        $this->setTemplate('gpec_user/skills.phtml');
    }

    /**
     * Render HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }

}