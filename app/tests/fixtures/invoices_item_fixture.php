<?php
/* InvoicesItem Fixture generated on: 2014-02-23 21:16:35 : 1393190195 */
class InvoicesItemFixture extends CakeTestFixture {
	var $name = 'InvoicesItem';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
		'description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'quantity' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'cost' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 5),
		'cleared' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'invoice' => array('column' => 'invoice_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'invoice_id' => 2,
			'description' => 'Regular',
			'amount' => 50,
			'quantity' => 13.75,
			'cost' => 40,
			'ordering' => 0,
			'cleared' => 0
		),
	);
}
/*
<?xml version="1.0"?>
<invoices-item>
  <id>1</id>
  <invoice_id>2</invoice_id>
  <description>Regular</description>
  <amount>50</amount>
  <quantity>13.75</quantity>
  <cost>40</cost>
  <ordering>0</ordering>
  <cleared>0</cleared>
  <date-generated>Fri, 24 Jan 2014 23:40:31</date-generated>
  <invoice-commissions-items>
    <id>7</id>
    <id>8</id>
  </invoice-commissions-items>
</invoices-item>
*/