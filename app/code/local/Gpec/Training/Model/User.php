<?php

/**
 * Job Model
 *
 * @category    Gpec
 * @package     Gpec_training
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Training_Model_User extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('gpec_training/user');
    }

}
