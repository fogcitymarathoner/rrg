<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheClientOpenInvoicesShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {

        App::import('Model', 'cache/client');

    	$clientModel = new ClientCache;
        $clientModel->cache_client_open_invoices();
    	exit;

    }

    function help() {
        $this->out('Here comes the help message');
    }
}
