<?php
/* SVN FILE: $Id$ */
/* Invoiice Test cases generated on: 2010-11-15 11:26:05 : 1289849165*/
App::import('Model', 'Invoice');
require_once('app/config/database.php');
class StateControllerTestCase extends CakeTestCase {
    var $Invoice = null;
    var $fixtures = array('app.invoice', 'app.client', 'app.clients_contract',
        'app.employee', 'app.invoices_item', 'app.state');

    function startTest() {

        $this->Invoice =& ClassRegistry::init('Invoice');
    }

    function testInvoiceInstance() {
        $this->assertTrue(is_a($this->Invoice, 'Invoice'));
    }

    function testStateIndex() {


        $results = $this->testAction('states',array('data'=>Null, 'method'=>'get','return'=>'vars'));
        $this->assertEqual($results['states'][0]['State'] ['id'], 5);
        $this->assertEqual(count($results['states']), 1);

    }
    function testStateView() {


        $results = $this->testAction('states',array('data'=>Null, 'method'=>'get','return'=>'vars'));
        $this->assertEqual($results['states'][0]['State'] ['id'], 5);
        $this->assertEqual(count($results['states']), 1);

        $results = $this->testAction('states/view/5',array('data'=>array('id' => 5), 'method'=>'get','return'=>'vars'));

        // view with id
        $this->assertEqual($results['state']['State'] ['id'], 5);
        // test binds
        $this->assertEqual(count($results['state']), 4);
        $this->assertPattern('/Evans Analytical Group LLC/', $results['state']['Client'][0]['name']);
        $this->assertPattern('/KITTY/', $results['state']['Employee'][0]['firstname']);

        $this->assertEqual(count($results['state']['Client']), 1);
        $this->assertEqual(count($results['state']['Employee']), 1);
        $this->assertEqual(count($results['state']['Vendor']), 0);

        // view wirh no id
        $results = $this->testAction('states/view',array('data'=>array('id' => 5), 'method'=>'get','return'=>'vars'));

        $this->assertEqual(count($results['states']), 1);

        // edit wirh no id
        $results = $this->testAction('states/edit',array('data'=>array('id' => 5), 'method'=>'get','return'=>'vars'));
        debug($results);
    }
}
?>