<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'gpec_skill/skill'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_skill/skill'))
    ->addColumn('skill_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
        ), 'Skill ID')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Skill identifier')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Skill name')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Skill description')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Update Time')
    ->setComment('Skill');
$installer->getConnection()->createTable($table);

$installer->endSetup();
