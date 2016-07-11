<?php
/* NotesPayment Fixture generated on: 2014-02-23 21:16:40 : 1393190200 */
class NotesPaymentFixture extends CakeTestFixture {
	var $name = 'NotesPayment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'commissions_report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'commissions_reports_tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'check_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 25, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'notes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'voided' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'commissions_report' => array('column' => 'commissions_report_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'commissions_report_id' => 1,
			'commissions_reports_tag_id' => 1,
			'check_number' => 'Lorem ipsum dolor sit a',
			'date' => '2014-02-23',
			'amount' => 1,
			'notes' => 'Lorem ipsum dolor sit amet',
			'voided' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
	);
}
