<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'gpec_report/report'
 */
try {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('gpec_report/report'))
        ->addColumn('report_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'Report ID')
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => false,
                'default' => '0'
            ), 'User Id')
        ->addColumn('author_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => false,
                'default' => '0'
            ), 'Author Id')
        ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => false,
                'default' => '0'
            ), 'Type Id')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Report name')
        ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Report content')
        ->addColumn('file_path_1', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'File path 1')
        ->addColumn('file_path_2', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'File path 2')
        ->addColumn('file_path_3', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'File path 3')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
        ->addIndex($installer->getIdxName('gpec_report/report', array(
            'user_id',
            'type_id'
        )), array(
            'user_id',
            'type_id'
        ))
        ->setComment('Report');

    $installer->getConnection()->createTable($table);

} catch(Exception $e) {
    echo $e->getMessage(); die;
}
$installer->endSetup();
