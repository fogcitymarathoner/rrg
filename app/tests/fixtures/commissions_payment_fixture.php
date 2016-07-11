<?php
/* CommissionsPayment Fixture generated on: 2014-02-23 21:16:24 : 1393190184 */
class CommissionsPaymentFixture extends CakeTestFixture {
	var $name = 'CommissionsPayment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'commissions_report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'commissions_reports_tag_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'note_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'check_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'cleared' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'voided' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'commissions_report' => array('column' => 'commissions_report_id', 'unique' => 0), 'commissions_reports_tag' => array('column' => 'commissions_reports_tag_id', 'unique' => 0), 'note' => array('column' => 'note_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'commissions_report_id' => 1,
			'commissions_reports_tag_id' => 1,
			'note_id' => 1,
			'check_number' => 'Lorem ip',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'date' => '2014-02-23',
			'amount' => 1,
			'cleared' => 1,
			'voided' => 1
		),
	);
}
