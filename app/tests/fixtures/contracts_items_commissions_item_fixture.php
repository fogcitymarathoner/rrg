<?php
/* ContractsItemsCommissionsItem Fixture generated on: 2014-02-23 21:16:27 : 1393190187 */
class ContractsItemsCommissionsItemFixture extends CakeTestFixture {
	var $name = 'ContractsItemsCommissionsItem';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'contracts_items_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'percent' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'item' => array('column' => 'contracts_items_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'contracts_items_id' => 1,
			'percent' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:27',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
	);
}
