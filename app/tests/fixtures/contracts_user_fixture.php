<?php
/* ContractsUser Fixture generated on: 2014-02-23 21:16:28 : 1393190188 */
class ContractsUserFixture extends CakeTestFixture {
	var $name = 'ContractsUser';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contract_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE' => array('column' => array('contract_id', 'user_id'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'contract_id' => 1,
			'user_id' => 1
		),
	);
}
