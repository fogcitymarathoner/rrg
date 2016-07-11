<?php
/* ContractsItem Fixture generated on: 2014-02-23 21:16:26 : 1393190186 */
class ContractsItemFixture extends CakeTestFixture {
	var $name = 'ContractsItem';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'contract_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'amt' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'cost' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'notes' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 5),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'contract' => array('column' => 'contract_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'active' => 1,
			'contract_id' => 1,
			'description' => 'Lorem ipsum dolor sit amet',
			'amt' => 1,
			'cost' => 1,
			'notes' => 'Lorem ipsum dolor sit amet',
			'ordering' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:26',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
	);
}
