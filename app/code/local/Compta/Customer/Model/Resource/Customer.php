<?php

class Compta_Customer_Model_Resource_Customer extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();

        $this->_customerTable = $this->getTable('compta_customer/customer');
    }

    public function _construct()
    {
        $this->_init('compta_customer/customer', 'customer_id');
    }

    /**
     * Get user ides
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getUserIds($customer)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'customer_id' => (int) $customer->getId()
        );

        $select = $read->select()
            ->from($this->_customerUserTable, array('user_id'))
            ->where('customer_id = :customer_id');

        return $read->fetchCol($select, $binds);
    }

    /**
     * @param Compta_Customer_Model_Customer $model
     * @return $this
     */
    public function _saveUserIds($model)
    {
        $addedIds = $model->getPostedUserIds();

        if(!is_array($addedIds)){
            return $this;
        }

        $bind = array(
            'customer_id'   => $model->getId(),
        );
        $write = $this->_getWriteAdapter();

        $select = $write->select()
            ->from($this->_customerUserTable, 'user_id')
            ->where('customer_id = :customer_id');
        $oldRelationIds = $write->fetchCol($select, $bind);

        $insert = array_diff($addedIds, $oldRelationIds);
        $delete = array_diff($oldRelationIds, $addedIds);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $value) {
                $insertData[] = array(
                    'customer_id'    => $model->getId(),
                    'user_id'    => $value,
                );
            }
            $write->insertMultiple($this->_customerUserTable, $insertData);
        }

        if (!empty($delete)) {
            $write->delete($this->_customerUserTable, array(
                'user_id IN (?)' => $delete,
                'customer_id'    => $model->getId()
            ));
        }

        return $this;
    }

    /**
     * Process customer data before save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Compta_customer_Model_Resource_Customer
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        /**
         * Update timestamp values
         */
        $date = $this->formatDate(Mage::getModel('core/date')->gmtTimestamp());
        if (! $object->getCreatedAt()) {
            $object->setCreatedAt($date);
        }
        $object->setUpdatedAt($date);
        
        return parent::_beforeSave($object);
    }

    /**
     * Process slider data after save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Atecna_Slider_Model_Resource_Slider
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        //$this->_saveUserIds($object);
        return parent::_afterSave($object);
    }
}
