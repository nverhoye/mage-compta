<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'compta_invoice/invoice'
 */
try {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('compta_invoice/invoice'))
        ->addColumn('invoice_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'Invoice ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => false,
                'default' => '0'
            ), 'User Id')
        ->addColumn('number', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Invoice name')
        ->addColumn('amount', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Invoice name')
        ->addColumn('payment_limit', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Invoice name')
        ->addColumn('payment_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Invoice name')
        ->addColumn('quarter', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(), 'Invoice name')
        ->addColumn('adjusted', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => false,
                'default' => '0'
            ), 'Invoice name')
        ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Invoice content')
        ->addColumn('file_path_1', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'File path 1')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
        ->addIndex($installer->getIdxName('compta_invoice/invoice', array(
            'customer_id'
        )), array(
            'customer_id'
        ))
        ->setComment('Invoice');

    $installer->getConnection()->createTable($table);

} catch(Exception $e) {
    echo $e->getMessage(); die;
}
$installer->endSetup();
