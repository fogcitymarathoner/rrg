<?php
/* Vendor Fixture generated on: 2014-02-23 21:16:46 : 1393190206 */
class VendorFixture extends CakeTestFixture {
	var $name = 'Vendor';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'purpose' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'street1' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'street2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'zip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'ssn' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 11, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'apfirstname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 31, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'aplastname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 11, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'apemail' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 55, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'apphonetype1' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2),
		'apphone1' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'apphonetype2' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2),
		'apphone2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 34, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'accountnumber' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 65, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'notes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 183, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'secretbits' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'purpose' => 'Lorem ipsum dolor sit amet',
			'street1' => 'Lorem ipsum dolor sit amet',
			'street2' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor ',
			'state_id' => 1,
			'zip' => 'Lorem ip',
			'active' => 1,
			'ssn' => 'Lorem ips',
			'apfirstname' => 'Lorem ipsum dolor sit amet',
			'aplastname' => 'Lorem ips',
			'apemail' => 'Lorem ipsum dolor sit amet',
			'apphonetype1' => 1,
			'apphone1' => 'Lorem ipsum dolor sit amet',
			'apphonetype2' => 1,
			'apphone2' => 'Lorem ipsum dolor sit amet',
			'accountnumber' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet',
			'secretbits' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'modified_date' => '2014-02-23 21:16:46',
			'created_date' => '2014-02-23',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
	);
}
