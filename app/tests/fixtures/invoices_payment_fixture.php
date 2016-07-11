<?php
/* InvoicesPayment Fixture generated on: 2014-02-23 21:16:37 : 1393190197 */
class InvoicesPaymentFixture extends CakeTestFixture {
	var $name = 'InvoicesPayment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'notes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'check_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'ordering' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'invoice' => array('column' => 'invoice_id', 'unique' => 0), 'check' => array('column' => 'check_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'invoice_id' => 1,
			'amount' => 1,
			'notes' => 'Lorem ipsum dolor sit amet',
			'check_id' => 1,
			'ordering' => 1
		),
	);
}
