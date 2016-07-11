<?php
/* EmployeesEmail Fixture generated on: 2014-02-23 21:16:29 : 1393190189 */
class EmployeesEmailFixture extends CakeTestFixture {
	var $name = 'EmployeesEmail';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'email' => 'Lorem ipsum dolor sit amet'
		),
	);
}
