<?php

/**
 * Adminhtml skill content
 *
 * @category   Compta
 * @package    Compta_Skill
 * @author     Compta <contact@compta.fr>
 */
class Compta_Invoice_Block_Adminhtml_Renderer_Adjusted extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $trans = array(
            '0' => 'Non',
            '1' => 'Oui'
        );
        return $trans[$row->getData('adjusted')];
    }


}