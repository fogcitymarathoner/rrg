<?php
/* SVN FILE: $Id$ */
/* Invoiice Test cases generated on: 2010-11-15 11:26:05 : 1289849165*/
App::import('Model', 'Invoice');
require_once('app/config/database.php');
class InvoiceControllerTestCase extends CakeTestCase {
    var $Invoice = null;
    var $fixtures = array('app.invoice', 'app.client', 'app.clients_contract',
        'app.employee', 'app.invoices_item', 'app.state');

    function startTest() {

        $this->Invoice =& ClassRegistry::init('Invoice');
    }

    function testInvoiceInstance() {
        $this->assertTrue(is_a($this->Invoice, 'Invoice'));
    }

    function testInvoiceFind() {
        $this->Invoice->recursive = -1;
        $results = $this->Invoice->find('first');
        $this->assertTrue(!empty($results));
        $expected = array('Invoice' => array(
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
        ));
        $this->assertEqual($results, $expected);

        $results = $this->testAction('invoices',array('data'=>Null, 'method'=>'get','return'=>'vars'));

        $this->assertEqual($results['invoices'][0]['Invoice'] ['id'], 19);
        $this->assertEqual(count($results['invoices']), 1);
    }
}
?>