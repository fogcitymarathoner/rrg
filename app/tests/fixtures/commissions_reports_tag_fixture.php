<?php
/* CommissionsReportsTag Fixture generated on: 2014-02-23 21:16:25 : 1393190185 */
class CommissionsReportsTagFixture extends CakeTestFixture {
	var $name = 'CommissionsReportsTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'commissions_report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'employee_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'comm_balance' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'note_balance' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'cleared' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'release' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'unique_report_salesperson' => array('column' => array('commissions_report_id', 'employee_id'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'commissions_report_id' => 1,
			'employee_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'comm_balance' => 1,
			'note_balance' => 1,
			'amount' => 1,
			'cleared' => 1,
			'release' => 1
		),
	);
}
