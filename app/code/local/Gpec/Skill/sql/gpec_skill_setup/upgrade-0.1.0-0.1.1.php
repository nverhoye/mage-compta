<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Add columns
 */
$installer->getConnection()->addColumn($installer->getTable('gpec_skill/skill'),'category',"VARCHAR( 255 ) NULL COMMENT 'Job category' AFTER `name`");



/**
 * Create table 'gpec_job/skill'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('gpec_job/skill'))
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
            'primary' => true,
            'default' => '0'
        ), 'Job Id')
    ->addColumn('skill_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'default' => '0'
        ), 'Skill Id')
    ->addIndex($installer->getIdxName('gpec_job/job', array(
        'job_id',
    )), array(
        'job_id'
    ))
    ->addForeignKey($installer->getFkName('gpec_job/job', 'job_id', 'gpec_job/job', 'job_id'), 'job_id',
        $installer->getTable('gpec_job/job'), 'job_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Job skill links');
$installer->getConnection()->createTable($table);

$installer->endSetup();
