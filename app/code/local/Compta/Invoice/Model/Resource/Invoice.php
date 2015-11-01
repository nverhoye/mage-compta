<?php

class Compta_Invoice_Model_Resource_Invoice extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     */
    public function __construct()
    {
        parent::__construct();

        $this->_invoiceTable = $this->getTable('compta_invoice/invoice');
    }

    public function _construct()
    {
        $this->_init('compta_invoice/invoice', 'invoice_id');
    }

    /**
     * Get user ides
     *
     * @param Atecna_Slider_Model_Slider $supercodepromo
     * @return array
     */
    public function getUserIds($invoice)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'invoice_id' => (int) $invoice->getId()
        );

        $select = $read->select()
            ->from($this->_invoiceUserTable, array('user_id'))
            ->where('invoice_id = :invoice_id');

        return $read->fetchCol($select, $binds);
    }

    /**
     * @param Compta_Invoice_Model_Invoice $model
     * @return $this
     */
    public function _saveUserIds($model)
    {
        $addedIds = $model->getPostedUserIds();

        if(!is_array($addedIds)){
            return $this;
        }

        $bind = array(
            'invoice_id'   => $model->getId(),
        );
        $write = $this->_getWriteAdapter();

        $select = $write->select()
            ->from($this->_invoiceUserTable, 'user_id')
            ->where('invoice_id = :invoice_id');
        $oldRelationIds = $write->fetchCol($select, $bind);

        $insert = array_diff($addedIds, $oldRelationIds);
        $delete = array_diff($oldRelationIds, $addedIds);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $value) {
                $insertData[] = array(
                    'invoice_id'    => $model->getId(),
                    'user_id'    => $value,
                );
            }
            $write->insertMultiple($this->_invoiceUserTable, $insertData);
        }

        if (!empty($delete)) {
            $write->delete($this->_invoiceUserTable, array(
                'user_id IN (?)' => $delete,
                'invoice_id'    => $model->getId()
            ));
        }

        return $this;
    }

    /**
     * Process invoice data before save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Compta_invoice_Model_Resource_Invoice
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
