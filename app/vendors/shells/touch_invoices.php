<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class TouchInvoicesShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {
    	

        App::import('Model', 'InvoiceToucher');
    	App::import('Model', 'InvoicesItemsCommissionsItem');
        App::import('Controller', 'CommissionsReports');
    	$ItModel = new InvoiceToucher;
        $ItModel->touch_invoices();
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
