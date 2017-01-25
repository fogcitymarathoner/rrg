<?php
/* Employee Fixture generated on: 2014-02-23 21:16:29 : 1393190189 */
class EmployeeFixture extends CakeTestFixture {
	var $name = 'Employee';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'firstname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mi' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nickname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ssn_crypto' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dob' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'enddate' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'startdate' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
		'street1' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'street2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'zip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bankaccountnumber_crypto' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bankaccounttype' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 8, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bankname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 35, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bankroutingnumber_crypto' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'directdeposit' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'allowancefederal' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
		'allowancestate' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
		'extradeductionfed' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
		'extradeductionstate' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
		'maritalstatusfed' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'maritalstatusstate' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'usworkstatus' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 5),
		'notes' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tcard' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'active' => array('type' => 'integer', 'null' => true, 'default' => '1', 'key' => 'index'),
		'voided' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'w4' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'de34' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'i9' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'medical' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indust' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'info' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'salesforce' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'last_sync_time' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => 'username', 'unique' => 1), 'slug' => array('column' => 'slug', 'unique' => 1), 'active_index' => array('column' => 'active', 'unique' => 0), 'voided' => array('column' => 'voided', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'slug' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'firstname' => 'Lorem ipsum dolor ',
			'lastname' => 'Lorem ipsum dolor ',
			'mi' => '',
			'nickname' => 'Lorem ipsum dolor ',
			'ssn_crypto' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'dob' => '2014-02-23',
			'enddate' => '2014-02-23',
			'startdate' => '2014-02-23',
			'street1' => 'Lorem ipsum dolor sit amet',
			'street2' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor ',
			'state_id' => 1,
			'zip' => 'Lorem ip',
			'bankaccountnumber_crypto' => 'Lorem ipsum dolor sit amet',
			'bankaccounttype' => 'Lorem ',
			'bankname' => 'Lorem ipsum dolor sit amet',
			'bankroutingnumber_crypto' => 'Lorem ipsum dolor sit amet',
			'directdeposit' => 1,
			'allowancefederal' => 1,
			'allowancestate' => 1,
			'extradeductionfed' => 1,
			'extradeductionstate' => 1,
			'maritalstatusfed' => 'Lorem ipsum dolor sit amet',
			'maritalstatusstate' => 'Lorem ipsum dolor sit amet',
			'usworkstatus' => 1,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tcard' => 1,
			'active' => 1,
			'voided' => 1,
			'w4' => 1,
			'de34' => 1,
			'i9' => 1,
			'medical' => 1,
			'indust' => 1,
			'info' => 1,
			'phone' => 'Lorem ipsum dolor sit amet',
			'salesforce' => 1,
			'created_date' => '2014-02-23',
			'modified_date' => '2014-02-23 21:16:29',
			'created_user_id' => 1,
			'modified_user_id' => 1,
			'last_sync_time' => 1393190189
		),
		array(
			'id' => 1528,
			'slug' => 'kitty-yuen-1528',
			'username' => 'emp1450@fogtest.com166',
			'firstname' => 'KITTY',
			'lastname' => 'YUEN',
			'mi' => '',
			'nickname' => '',
			'ssn_crypto' => '$E$Ky8ZipEgf/I7gbkJPZ6CLeN1Bs9lWAWb',
			'password' => 'Lorem ipsum dolor sit amet',
			'dob' => '',
			'enddate' => '2009-10-02',
			'startdate' => '2009-07-20',
			'street1' => '1514 CLEAR LAKE AVENUE',
			'street2' => '',
			'city' => 'MILPITAS',
			'state_id' => 5,
			'zip' => '95035',
			'bankaccountnumber_crypto' => '$E$7U48VguQum6Gh48WZOHQLQ==',
			'bankaccounttype' => 'Checking',
			'bankname' => 'Tech CU',
			'bankroutingnumber_crypto' => '$E$cghhCtrpsSZ6MuU0NYvcus7yECHSaNVt',
			'directdeposit' => 1,
			'allowancefederal' => 1,
			'allowancestate' => 1,
			'extradeductionfed' => 0,
			'extradeductionstate' => 0,
			'maritalstatusfed' => Null,
			'maritalstatusstate' => Null,
			'usworkstatus' => 0,
			'notes' => Null,
			'tcard' => 1,
			'active' => 1,
			'voided' => 1,
			'w4' => 1,
			'de34' => 1,
			'i9' => 1,
			'medical' => 1,
			'indust' => 1,
			'info' => 1,
			'phone' => '415 686 8838',
			'salesforce' => 0,
			'created_date' => Null,
			'modified_date' => '2012-01-29 00:00:00',
			'created_user_id' => Null,
			'modified_user_id' => Null,
			'last_sync_time' => '2013-12-17 06:15:10'
		),
	);
}
/*
<?xml version="1.0"?>
<employee>
  <id>1528</id>
  <slug>kitty-yuen-1528</slug>
  <username>emp1450@fogtest.com166</username>
  <firstname>KITTY</firstname>
  <lastname>YUEN</lastname>
  <mi></mi>
  <nickname></nickname>
  <ssn_crypto>$E$Ky8ZipEgf/I7gbkJPZ6CLeN1Bs9lWAWb</ssn_crypto>
  <dob></dob>
  <enddate>2009-10-02</enddate>
  <startdate>2009-07-20</startdate>
  <street1>1514 CLEAR LAKE AVENUE</street1>
  <street2></street2>
  <city>MILPITAS</city>
  <state_id>5</state_id>
  <zip>95035</zip>
  <bankaccountnumber_crypto>$E$7U48VguQum6Gh48WZOHQLQ==</bankaccountnumber_crypto>
  <bankaccounttype>Checking</bankaccounttype>
  <bankname>Tech CU</bankname>
  <bankroutingnumber_crypto>$E$cghhCtrpsSZ6MuU0NYvcus7yECHSaNVt</bankroutingnumber_crypto>
  <directdeposit>1</directdeposit>
  <allowancefederal>1</allowancefederal>
  <allowancestate>1</allowancestate>
  <extradeductionfed></extradeductionfed>
  <extradeductionstate></extradeductionstate>
  <maritalstatusfed></maritalstatusfed>
  <maritalstatusstate></maritalstatusstate>
  <usworkstatus>0</usworkstatus>
  <notes></notes>
  <tcard>1</tcard>
  <active>0</active>
  <voided>0</voided>
  <w4>1</w4>
  <de34>1</de34>
  <i9>1</i9>
  <medical>1</medical>
  <indust>1</indust>
  <info>1</info>
  <phone>415 686 8838</phone>
  <salesforce>0</salesforce>
  <created_date></created_date>
  <modified_date>2012-01-29 00:00:00</modified_date>
  <created_user_id></created_user_id>
  <modified_user_id></modified_user_id>
  <last_sync_time>2013-12-17 06:15:10</last_sync_time>
  <date-generated>Sun, 23 Feb 2014 22:41:01</date-generated>
  <profile>
    <id>472</id>
  </profile>
  <contracts>
    <id>1527</id>
  </contracts>
  <letters/>
  <memos/>
  <payments>
    <id>3</id>
    <id>9</id>
    <id>10</id>
    <id>13</id>
    <id>14</id>
    <id>15</id>
    <id>19</id>
    <id>20</id>
    <id>23</id>
    <id>30</id>
    <id>37</id>
    <id>50</id>
  </payments>
  <emails>
    <id>312</id>
  </emails>
  <commissions-tags/>
  <commissions-payments/>
  <notes/>
  <notes-payments/>
  <expenses/>
  <commissions/>
</employee>

*/
