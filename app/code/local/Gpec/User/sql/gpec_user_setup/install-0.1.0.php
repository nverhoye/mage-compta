<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$table = new Varien_Db_Ddl_Table();
$table->setName($this->getTable('admin/user'));
$table->addColumn('manager_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10,
    array('unsigned' => true, 'nullable' => false, 'default'=> "0"));

//ALTER TABLE admin_user ADD manager_id INT NOT NULL DEFAULT 0 AFTER password;

$installer->endSetup();
