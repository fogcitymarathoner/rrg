<?php
/* ClientsCheck Fixture generated on: 2014-02-23 21:16:21 : 1393190181 */
class ClientsCheckFixture extends CakeTestFixture {
	var $name = 'ClientsCheck';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'number' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'notes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'last_sync_time' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'client' => array('column' => 'client_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'client_id' => 1,
			'number' => 'Lorem ipsum dolor ',
			'amount' => 1,
			'notes' => 'Lorem ipsum dolor sit amet',
			'date' => '2014-02-23',
			'created_date' => '2014-02-23',
			'created_user_id' => 1,
			'modified_user_id' => 1,
			'modified_date' => '2014-02-23',
			'last_sync_time' => 1393190181
		),
	);
}
