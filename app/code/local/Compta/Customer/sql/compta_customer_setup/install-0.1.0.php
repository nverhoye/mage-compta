<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'compta_customer/customer'
 */
try {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('compta_customer/customer'))
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'Customer ID')
        ->addColumn('nom', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->addColumn('street', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->addColumn('city', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->addColumn('postcode', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->addColumn('street', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->addColumn('phone',  Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->addColumn('email',  Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Customer name')
        ->setComment('Customer');

    $installer->getConnection()->createTable($table);

} catch(Exception $e) {
    echo $e->getMessage(); die;
}
$installer->endSetup();
