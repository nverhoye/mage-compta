<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Update table 'compta_customer/customer'
 */
try {

    $this->getConnection()
        ->addColumn($installer->getTable('compta_customer/customer'),'thm', array(
            'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'nullable'  => true,
            'length'    => 10,
            'comment'   => 'Taux horaire HT'
        ));

    $this->getConnection()
        ->addColumn($installer->getTable('compta_customer/customer'),'paiement_delay', array(
            'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'nullable'  => true,
            'length'    => 10,
            'comment'   => 'Délais paiement'
        ));

    $this->getConnection()
        ->addColumn($installer->getTable('compta_customer/customer'),'color', array(
            'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
            'nullable'  => true,
            'length'    => 10,
            'comment'   => 'Couleur'
        ));

} catch(Exception $e) {
    echo $e->getMessage(); die;
}
$installer->endSetup();
