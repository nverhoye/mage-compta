<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'gpec_training/training'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_training/training'))
    ->addColumn('training_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ), 'Training ID')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Training identifier')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Job name')
    ->addColumn('trainer', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Job name')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Job description')
    ->addColumn('file_path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Creation Time')
    ->addColumn('started_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Start Time')
    ->addColumn('ended_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'End Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Update Time')
    ->setComment('Training');

$installer->getConnection()->createTable($table);

/**
 * Create table 'gpec_training/user'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_training/user'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ), 'Entity Id')
    ->addColumn('training_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'default' => '0'
        ), 'Training Id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'default' => '0'
        ), 'User Id')
    ->addIndex(
        $installer->getIdxName(
            'gpec_training/training',
            array(
                'training_id',
                'user_id'
            ),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array(
            'training_id',
            'user_id'
        ),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey($installer->getFkName('gpec_training/training', 'training_id', 'gpec_training/training', 'training_id'), 'training_id',
        $installer->getTable('gpec_training/training'), 'training_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Training user links');
$installer->getConnection()->createTable($table);


$installer->endSetup();
