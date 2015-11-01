<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'gpec_job/job'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_job/job'))
    ->addColumn('job_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
        ), 'Job ID')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Job identifier')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Job name')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Job description')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Update Time')
    ->setComment('Job');
$installer->getConnection()->createTable($table);

$installer->endSetup();
