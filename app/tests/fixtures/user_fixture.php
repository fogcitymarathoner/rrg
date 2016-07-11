<?php
/* User Fixture generated on: 2014-02-23 21:16:46 : 1393190206 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'firstname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lastname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'group_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 11, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2),
		'phone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'last_logged_in' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'fb_session_key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 44, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fbid' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'fb_session_expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'fb_created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'fb_last_logged_in' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'unique_name' => array('column' => 'username', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'firstname' => 'Lorem ipsum dolor sit amet',
			'lastname' => 'Lorem ipsum dolor sit amet',
			'group_id' => 'Lorem ips',
			'active' => 1,
			'phone' => 'Lorem ipsum dolor sit amet',
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:46',
			'last_logged_in' => '2014-02-23 21:16:46',
			'fb_session_key' => 'Lorem ipsum dolor sit amet',
			'fbid' => 1,
			'fb_session_expires' => 1,
			'fb_created_date' => '2014-02-23',
			'fb_last_logged_in' => '2014-02-23 21:16:46'
		),
	);
}
