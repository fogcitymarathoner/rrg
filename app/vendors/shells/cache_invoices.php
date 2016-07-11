<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheInvoicesShell extends Shell {
	#var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/invoice');

        $invoiceModel = new InvoiceCache;
        if(count($this->args)==0 )
            exit;

        $invoiceModel->cache_invoices( $this->args[0]);
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
