<?php
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote_payment'), 'inn', 'VARCHAR(255)');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote_payment'), 'kpp', 'VARCHAR(255)');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote_payment'), 'bik', 'VARCHAR(255)');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote_payment'), 'account', 'VARCHAR(255)');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote_payment'), 'payer', 'VARCHAR(255)');



$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('order_payment', 'inn', array());
$setup->addAttribute('order_payment', 'kpp', array());
$setup->addAttribute('order_payment', 'bik', array());
$setup->addAttribute('order_payment', 'account', array());
$setup->addAttribute('order_payment', 'payer', array());

$setup->addAttribute('quote_payment', 'inn', array());
$setup->addAttribute('quote_payment', 'kpp', array());
$setup->addAttribute('quote_payment', 'bik', array());
$setup->addAttribute('quote_payment', 'account', array());
$setup->addAttribute('quote_payment', 'payer', array());



$installer->endSetup();
