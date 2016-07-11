<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class DeleteOldZeroedInvoiceItemsShell extends Shell {
	var $uses = array('Invoice');
	
    function initialize() {
        // empty
    }

    function main() {

        App::import('Model', 'cache/invoice');

    	$invModel = new InvoiceCache;
    	$invModel->delete_clear_zero_items();
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
