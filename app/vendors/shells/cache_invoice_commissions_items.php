<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheInvoiceCommissionsItemsShell extends Shell {
	#var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {

        App::import('Model', 'cache/invoices_items_commissions_item');


        $commItemModel = new InvoicesItemsCommissionsItemCache;

        if(count($this->args)==0 )
            exit;

        $commItemModel->cache_comm_items($this->args[0]);
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
