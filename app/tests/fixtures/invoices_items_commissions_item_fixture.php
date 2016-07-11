<?php
/* InvoicesItemsCommissionsItem Fixture generated on: 2014-02-23 21:16:36 : 1393190196 */
class InvoicesItemsCommissionsItemFixture extends CakeTestFixture {
	var $name = 'InvoicesItemsCommissionsItem';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'invoices_item_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'commissions_report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'commissions_reports_tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'percent' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'rel_inv_amt' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'rel_inv_line_item_amt' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'rel_item_amt' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'rel_item_quantity' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'rel_item_cost' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'cleared' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'voided' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'created_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'last_sync_time' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'invoice_item' => array('column' => 'invoices_item_id', 'unique' => 0), 'commissions_report' => array('column' => 'commissions_report_id', 'unique' => 0), 'commissions_reports_tag' => array('column' => 'commissions_reports_tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'invoices_item_id' => 1,
			'commissions_report_id' => 1,
			'commissions_reports_tag_id' => 1,
			'description' => 'Lorem ipsum dolor sit amet',
			'date' => '2014-02-23',
			'percent' => 1,
			'amount' => 1,
			'rel_inv_amt' => 1,
			'rel_inv_line_item_amt' => 1,
			'rel_item_amt' => 1,
			'rel_item_quantity' => 1,
			'rel_item_cost' => 1,
			'cleared' => 1,
			'voided' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:36',
			'created_user_id' => 1,
			'modified_user_id' => 1,
			'last_sync_time' => 1393190196
		),
	);
}
