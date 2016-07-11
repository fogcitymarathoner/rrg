<?php
/* Client Fixture generated on: 2014-02-23 21:16:20 : 1393190180 */
class ClientFixture extends CakeTestFixture {
	var $name = 'Client';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'street1' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'street2' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'zip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1', 'key' => 'index'),
		'terms' => array('type' => 'integer', 'null' => false, 'default' => '30', 'length' => 2),
		'hq' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'ssn_crypto' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'registration_attempt_counter' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'last_sync_time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ssn_crypto' => array('column' => 'ssn_crypto', 'unique' => 1), 'active' => array('column' => 'active', 'unique' => 0), 'state' => array('column' => 'state_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'street1' => 'Lorem ipsum dolor sit amet',
			'street2' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'state_id' => 1,
			'zip' => 'Lorem ipsum dolor sit amet',
			'active' => 1,
			'terms' => 1,
			'hq' => 1,
			'ssn_crypto' => 'Lorem ipsum dolor sit amet',
			'registration_attempt_counter' => 1,
			'modified_date' => '2014-02-23 21:16:20',
			'created_date' => '2014-02-23',
			'created_user' => 1,
			'modified_user' => 1,
			'last_sync_time' => '2014-02-23 21:16:20'
		),		array(
			'id' => 66,
			'name' => 'Evans Analytical Group LLC',
			'street1' => '2710 WALSH AVE',
			'street2' => '',
			'city' => 'SANTA CLARA',
			'state_id' => 5,
			'zip' => '95051',
			'active' => 1,
			'terms' => 30,
			'hq' => Null,
			'ssn_crypto' => Null,
			'registration_attempt_counter' => 1,
			'modified_date' => '2014-02-23 21:02:21',
			'created_date' => '0000-00-00',
			'created_user' => 5,
			'modified_user' => 5,
			'last_sync_time' => '2013-02-26 09:29:33'
		),
	);
}
/*
<?xml version="1.0"?>
<client>
  <id>66</id>
  <name>Evans Analytical Group LLC</name>
  <state>5</state>
  <street1>2710 WALSH AVE</street1>
  <street2></street2>
  <city>SANTA CLARA</city>
  <zip>95051</zip>
  <active>1</active>
  <terms>30</terms>
  <hq></hq>
  <ssn_crypto></ssn_crypto>
  <modified_date>2014-02-23 21:02:21</modified_date>
  <created_date>0000-00-00</created_date>
  <created_user>5</created_user>
  <modified_user>5</modified_user>
  <last_sync_time>2013-02-26 09:29:33</last_sync_time>
  <date-generated>Sun, 23 Feb 2014 21:26:25</date-generated>
</client>
*/