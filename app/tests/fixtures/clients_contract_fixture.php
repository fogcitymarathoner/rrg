<?php
/* ClientsContract Fixture generated on: 2014-02-23 21:16:21 : 1393190181 */
class ClientsContractFixture extends CakeTestFixture {
	var $name = 'ClientsContract';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'enddate' => array('type' => 'date', 'null' => true, 'default' => '0000-00-00'),
		'startdate' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
		'terms' => array('type' => 'integer', 'null' => false, 'default' => '30', 'length' => 2),
		'invoicemessage' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'po' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 12, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'potracking' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'employerexp' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '4,2'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1', 'key' => 'index'),
		'period_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'title' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'reports_to' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 75, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mock_invoice_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'addendum_executed' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'timecard_in_invoice' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'client' => array('column' => 'client_id', 'unique' => 0), 'employee' => array('column' => 'employee_id', 'unique' => 0), 'active' => array('column' => 'active', 'unique' => 0), 'period' => array('column' => 'period_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'client_id' => 1,
			'enddate' => '2014-02-23',
			'startdate' => '2014-02-23',
			'terms' => 1,
			'invoicemessage' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'po' => 'Lorem ipsu',
			'potracking' => 1,
			'employerexp' => 1,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'active' => 1,
			'period_id' => 1,
			'title' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'reports_to' => 'Lorem ipsum dolor sit amet',
			'mock_invoice_id' => 1,
			'addendum_executed' => 1,
			'timecard_in_invoice' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:21',
			'created_user_id' => 1,
			'modified_user_id' => 1
		),
		array(
			'id' => 1527,
			'employee_id' => 1528,
			'client_id' => 66,
			'enddate' => '2009-10-02',
			'startdate' => '2009-08-20',
			'terms' => 30,
			'invoicemessage' => 'Reports to Christine Russell',
			'po' => 'Lorem ipsu',
			'potracking' => 0,
			'employerexp' => 0.10,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'active' => 0,
			'period_id' => 1,
			'title' => 'For the professional services of Kitty Yuen - Paralegal',
			'reports_to' => '',
			'mock_invoice_id' => 1905,
			'addendum_executed' => 1,
			'timecard_in_invoice' => 0,
			'created_date' => '',
			'modified_date' => '2011-05-04 00:00:00',
			'created_user_id' => Null,
			'modified_user_id' => Null
		),
	);
}
/*
<?xml version="1.0"?>
<contract>
  <id>1527</id>
  <employee_id>1528</employee_id>
  <client_id>66</client_id>
  <enddate>2009-10-02</enddate>
  <startdate>2009-08-20</startdate>
  <terms>30</terms>
  <invoicemessage>Reports to Christine Russell</invoicemessage>
  <po></po>
  <potracking>0</potracking>
  <employerexp>0.10</employerexp>
  <notes></notes>
  <active>0</active>
  <period_id>1</period_id>
  <title>For the professional services of Kitty Yuen - Paralegal</title>
  <reports_to></reports_to>
  <mock_invoice_id>1905</mock_invoice_id>
  <addendum_executed>1</addendum_executed>
  <timecard_in_invoice>0</timecard_in_invoice>
  <created_date></created_date>
  <modified_date>2011-05-04 00:00:00</modified_date>
  <created_user_id></created_user_id>
  <modified_user_id></modified_user_id>
  <last_sync_time></last_sync_time>
  <date-generated>Sun, 23 Feb 2014 22:14:36</date-generated>
</contract>
*/