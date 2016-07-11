<?php
/* EmployeesPayment Fixture generated on: 2014-02-23 21:16:31 : 1393190191 */
class EmployeesPaymentFixture extends CakeTestFixture {
	var $name = 'EmployeesPayment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'invoice_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'payroll_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'date' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
		'ref' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'notes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'securitytoken' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'last_sync_time' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'securitytoken' => array('column' => 'securitytoken', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'invoice' => array('column' => 'invoice_id', 'unique' => 0), 'payroll' => array('column' => 'payroll_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'invoice_id' => 1,
			'payroll_id' => 1,
			'date' => '2014-02-23',
			'ref' => 'Lorem ipsum dolor ',
			'amount' => 1,
			'notes' => 'Lorem ipsum dolor sit amet',
			'ordering' => 1,
			'securitytoken' => 'Lorem ip',
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23',
			'created_user_id' => 1,
			'modified_user_id' => 1,
			'last_sync_time' => 1393190191
		),
	);
}
