<?php
/* Profile Fixture generated on: 2014-02-23 21:16:42 : 1393190202 */
class ProfileFixture extends CakeTestFixture {
	var $name = 'Profile';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'sphene_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'released_cat_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'released_cat_thread_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'internal_cat_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'internal_cat_thread_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => array('user_id', 'employee_id'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'employee_id' => 1,
			'sphene_id' => 1,
			'released_cat_id' => 1,
			'released_cat_thread_id' => 1,
			'internal_cat_id' => 1,
			'internal_cat_thread_id' => 1
		),
	);
}
