<?php
/* InvoicesOpening Fixture generated on: 2014-02-23 21:16:36 : 1393190196 */
class InvoicesOpeningFixture extends CakeTestFixture {
	var $name = 'InvoicesOpening';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'invoice_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'unique'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'invoice_id' => array('column' => 'invoice_id', 'unique' => 1), 'employee_id' => array('column' => 'invoice_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'invoice_id' => 1
		),
	);
}
