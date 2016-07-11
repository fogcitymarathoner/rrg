<?php
/* Expense Fixture generated on: 2014-02-23 21:16:32 : 1393190192 */
class ExpenseFixture extends CakeTestFixture {
	var $name = 'Expense';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 2, 'key' => 'index'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'cleared' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'notes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'category' => array('column' => 'category_id', 'unique' => 0), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'report' => array('column' => 'report_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'amount' => 1,
			'category_id' => 1,
			'employee_id' => 1,
			'report_id' => 1,
			'cleared' => 1,
			'date' => '2014-02-23',
			'description' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet'
		),
	);
}
