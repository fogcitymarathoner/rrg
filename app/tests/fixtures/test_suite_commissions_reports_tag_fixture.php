<?php
/* TestSuiteCommissionsReportsTag Fixture generated on: 2014-02-23 21:16:45 : 1393190205 */
class TestSuiteCommissionsReportsTagFixture extends CakeTestFixture {
	var $name = 'TestSuiteCommissionsReportsTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'commissions_report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'longname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'commissions_report_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'longname' => 'Lorem ipsum dolor sit amet'
		),
	);
}
