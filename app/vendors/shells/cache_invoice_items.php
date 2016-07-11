<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheInvoiceItemsShell extends Shell {
	#var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/invoices_item');

        $invoiceItemModel = new InvoicesItemCache;

        if(count($this->args)==0 )
            exit;
        $invoiceItemModel->cache_invoice_items($this->args[0]);

    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
