<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class ProtectCachedInvCommItemsShell extends Shell {
	#var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/invoices_items_commissions_item');

        $commItemModel = new InvoicesItemsCommissionsItemCache;

        print "beginning of ProtectCachedInvCommItemsShell\n";
        $commItemModel->protect_comm_items();
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
