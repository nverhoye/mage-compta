<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'compta_calendar/calendar'
 */
try {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('compta_calendar/calendar'))
        ->addColumn('calendar_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'Calendar ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => false,
                'default' => '0'
            ), 'Customer Id')
        ->addColumn('values', Varien_Db_Ddl_Table::TYPE_TEXT, Varien_Db_Ddl_Table::MAX_TEXT_SIZE, array(), 'Values')
        ->addIndex($installer->getIdxName('compta_calendar/calendar', array(
            'customer_id'
        )), array(
            'customer_id'
        ))
        ->setComment('Calendar');

    $installer->getConnection()->createTable($table);

} catch(Exception $e) {
    echo $e->getMessage(); die;
}
$installer->endSetup();
