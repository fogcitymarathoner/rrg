<?php
/* ClientsManager Fixture generated on: 2014-02-23 21:16:22 : 1393190182 */
class ClientsManagerFixture extends CakeTestFixture {
	var $name = 'ClientsManager';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'firstname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lastname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone1' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone2' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone1type' => array('type' => 'string', 'null' => true, 'default' => 'WORK', 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone2type' => array('type' => 'string', 'null' => true, 'default' => 'CELL', 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'client' => array('column' => 'client_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'client_id' => 1,
			'firstname' => 'Lorem ipsum dolor sit amet',
			'lastname' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'phone1' => 'Lorem ipsum dolor sit amet',
			'phone2' => 'Lorem ipsum dolor sit amet',
			'phone1type' => 'Lorem ipsum dolor sit amet',
			'phone2type' => 'Lorem ipsum dolor sit amet',
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:22',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
	);
}
