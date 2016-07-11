<?php
/* CommissionsReport Fixture generated on: 2014-02-23 21:16:25 : 1393190185 */
class CommissionsReportFixture extends CakeTestFixture {
	var $name = 'CommissionsReport';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'start' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'end' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'start' => '2014-02-23 21:16:25',
			'end' => '2014-02-23 21:16:25'
		),
	);
}
