<?php
/* VendorsMemo Fixture generated on: 2014-02-23 21:16:47 : 1393190207 */
class VendorsMemoFixture extends CakeTestFixture {
	var $name = 'VendorsMemo';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'vendor_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'notes' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'vendor' => array('column' => 'vendor_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'vendor_id' => 1,
			'date' => '2014-02-23',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
