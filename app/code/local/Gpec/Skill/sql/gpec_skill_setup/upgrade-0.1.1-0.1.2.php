<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'gpec_job/historic'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_skill/historic'))
    ->addColumn('historic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ), 'Entity Id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
            'default' => '0'
        ), 'User Id')
    ->addColumn('job_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
            'default' => '0'
        ), 'Job Id')
    ->addColumn('skills', Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
            'nullable' => false,
        ), 'Skills')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Created at')
    ->addIndex($installer->getIdxName('gpec_job/job', array(
        'user_id',
    )), array(
        'user_id'
    ))
    ->setComment('Job skill historic');
$installer->getConnection()->createTable($table);

$installer->endSetup();
