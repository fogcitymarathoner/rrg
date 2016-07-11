<?php
/* Note Fixture generated on: 2014-02-23 21:16:40 : 1393190200 */
class NoteFixture extends CakeTestFixture {
	var $name = 'Note';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'commissions_payment_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'commissions_report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'commissions_reports_tag_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'notes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'opening' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'voided' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'cleared' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'commissions_payment' => array('column' => 'commissions_payment_id', 'unique' => 0), 'commissions_report' => array('column' => 'commissions_report_id', 'unique' => 0), 'notes_reports' => array('column' => 'commissions_reports_tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'commissions_payment_id' => 1,
			'commissions_report_id' => 1,
			'commissions_reports_tag_id' => 1,
			'amount' => 1,
			'notes' => 'Lorem ipsum dolor sit amet',
			'date' => '2014-02-23',
			'opening' => 1,
			'voided' => 1,
			'cleared' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
	);
}
