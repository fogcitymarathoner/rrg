<?php
/* InvoicesPostLog Fixture generated on: 2014-02-23 21:16:38 : 1393190198 */
class InvoicesPostLogFixture extends CakeTestFixture {
	var $name = 'InvoicesPostLog';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'timestamp' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'invoice' => array('column' => 'invoice_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'invoice_id' => 1,
			'email' => 'Lorem ipsum dolor sit amet',
			'timestamp' => '2014-02-23 21:16:38'
		),
	);
}
