<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


/**
 * Create table 'gpec_job/user'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_job/user'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ), 'Entity Id')
    ->addColumn('job_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0'
        ), 'Job Id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0'
        ), 'User Id')
    ->addIndex(
        $installer->getIdxName(
            'gpec_job/job',
            array(
                'job_id',
                'user_id'
            ),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array(
            'job_id',
            'user_id'
        ),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey($installer->getFkName('gpec_job/job', 'job_id', 'gpec_job/job', 'job_id'). '_USER', 'job_id',
        $installer->getTable('gpec_job/job'), 'job_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Job user links');
$installer->getConnection()->createTable($table);

$installer->endSetup();
