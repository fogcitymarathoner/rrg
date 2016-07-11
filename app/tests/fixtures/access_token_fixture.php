<?php
/* AccessToken Fixture generated on: 2014-02-23 21:16:18 : 1393190178 */
class AccessTokenFixture extends CakeTestFixture {
	var $name = 'AccessToken';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'api_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'expiration' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'ip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'api_key' => 'Lorem ipsum dolor sit amet',
			'token' => 'Lorem ipsum dolor sit amet',
			'expiration' => '2014-02-23 21:16:18',
			'ip' => 'Lorem ipsum dolor ',
			'created_date' => '2014-02-23'
		),
	);
}
