<?php
/** @var Mage_Core_Model_Resource_Setup $this */
$this->startSetup();

$options = [
    'type'      => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'scale'     => 2,
    'precision' => 10,
    'nullable'  => false,
    'comment'   => 'Surcharge amount'
];

$conn->addColumn($this->getTable('sales/quote_address'), 'surcharge', $options);
$conn->addColumn($this->getTable('sales/quote_address'), 'base_surcharge', $options);

$conn->addColumn($this->getTable('sales/order'), 'surcharge', $options);
$conn->addColumn($this->getTable('sales/order'), 'base_surcharge', $options);

$this->endSetup();
