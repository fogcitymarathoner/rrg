<?php
/* State Fixture generated on: 2014-02-23 21:16:44 : 1393190204 */
class StateFixture extends CakeTestFixture {
	var $name = 'State';

	var $fields = array(
		'post_ab' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'capital' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 14, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'flower' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 27, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 14, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'state_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 9, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'post_ab' => 'CA',
			'capital' => 'Sacramento',
			'date' => '9-9-1850',
			'flower' => 'California Poppy',
			'name' => 'California',
			'state_no' => '38th',
			'id' => 5
		),
	);
}
