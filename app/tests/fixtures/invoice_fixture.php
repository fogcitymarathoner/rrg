<?php 
/* SVN FILE: $Id$ */
/* Invoice Fixture generated on: 2010-11-15 11:26:05 : 1289849165*/
/*
 * <?xml version="1.0"?>
    <invoice>
      <id>2</id>
      <contract_id>1527</contract_id>
      <date>2009-08-26</date>
      <po></po>
      <employerexpenserate>0.1</employerexpenserate>
      <terms>30</terms>
      <timecard>1</timecard>
      <notes>8/22 #10518</notes>
      <period_start>2009-08-17</period_start>
      <period_end>2009-08-23</period_end>
      <posted>1</posted>
      <cleared>1</cleared>
      <cleared_date>2009-11-03</cleared_date>
      <prcleared>1</prcleared>
      <timecard_receipt_sent>1</timecard_receipt_sent>
      <message></message>
      <amount>687.5</amount>
      <voided>0</voided>
      <token>gpPrwQbc</token>
      <view_count>1</view_count>
      <mock>0</mock>
      <timecard_document></timecard_document>
      <created_date>2013-02-06</created_date>
      <modified_date>2013-02-26 09:02:33</modified_date>
      <created_user_id>5</created_user_id>
      <modified_user_id>5</modified_user_id>
      <last_sync_time>2013-02-26 01:26:33</last_sync_time>
      <duedate>2009-09-25</duedate>
      <pdf_file_name>rocketsredglare_invoice_2_KITTY_YUEN_2009-08-17_to_2009-08-23.pdf</pdf_file_name>
      <employee>kitty-yuen-1528</employee>
      <employee_id>1528</employee_id>
      <date-generated>Fri, 24 Jan 2014 23:37:49</date-generated>
      <invoice-items>
        <id>1</id>
      </invoice-items>
      <invoice-payments>
        <id>19</id>
      </invoice-payments>
      <employee-payments>
        <id>3</id>
      </employee-payments>
    </invoice>

 */
class InvoiceFixture extends CakeTestFixture {
    var $name = 'Invoice';
    var $import = 'Invoice';
    var $table = 'invoices';
	var $records = array(
		array(
			'id'  => 1,
			'contract_id'  => 1527,
			'date'  => '2009-08-26',
			'po'  => '',
			'employerexpenserate'  => 0.1,
			'terms'  => 30,
			'timecard'  => 0,
			'notes'  => 'Blank Reminder',
			'period_start'  => '2009-08-17',
			'period_end'  => '2009-08-23',
			'posted'  => 0,
			'cleared'  => 0,
			'cleared_date'  => '2009-11-03',
			'prcleared'  => 1,
			'timecard_receipt_sent'  => 1,
			'message'  => '',
			'amount'  => 687.5,
			'voided'  => 0,
			'token'  => 'gpPrwQbc',
			'view_count'  => 1,
			'mock'  => 0,
			'timecard_document'  => '',
			'created_date'  => '2013-02-06',
			'modified_date'  =>'2013-02-26 09:02:33',
			'created_user_id'  =>5,
			'modified_user_id'  =>5,
			'last_sync_time'  => '2013-02-26 01:26:33',
		),
		
		array(
			'id'  => 19,
			'contract_id'  => 1527,
			'date'  => '2009-09-08',
			'po'  => '',
			'employerexpenserate'  => 0.1,
			'terms'  => 30,
			'timecard'  => 1,
			'notes'  => '9/4 #10524',
			'period_start'  => '2009-08-31',
			'period_end'  => '2009-09-06',
			'posted'  => 1,
			'cleared'  => 1,
			'cleared_date'  => '2009-11-01',
			'prcleared'  => 1,
			'timecard_receipt_sent'  => 1,
			'message'  => '',
			'amount'  => 4117.25,
			'voided'  => 0,
			'token'  => 'q9bjLU03',
			'view_count'  => Null,
			'mock'  => 0,
			'timecard_document'  => Null,
			'created_date'  => '2013-02-05',
			'modified_date'  =>'2013-12-07 17:12:51',
			'created_user_id'  =>5,
			'modified_user_id'  =>5,
			'last_sync_time'  => '2013-12-07 09:44:51',
		),
	);



}
?>