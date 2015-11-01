<?php

/**
 * Job Model
 *
 * @category    Gpec
 * @package     Gpec_training
 * @author      Gpec <contact@gpec.fr>
 */
class Gpec_Training_Model_Training extends Mage_Core_Model_Abstract
{

    const TRAINING_DIRECTORY = 'training/';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('gpec_training/training');
    }

    /**
     * @return array
     */
    public function getUserIds()
    {
        if (!$this->hasData('user_ids')) {
            $items = $this->_getResource()->getUserIds($this);
            $this->setData('user_ids', $items);
        }

        return (array)$this->getData('user_ids');
    }

}
