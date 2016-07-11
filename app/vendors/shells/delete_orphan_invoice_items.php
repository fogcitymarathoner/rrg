<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class DeleteOrphanInvoiceItemsShell extends Shell {
	var $uses = array('Invoice');
	
    function initialize() {
        // empty
    }

    function main() {
    	
    	App::import('Controller', 'App');
    	App::import('Model', 'Employee');
    	App::import('Controller', 'Employees');
    	App::import('Model', 'Reminder');
    	App::import('Model', 'CommissionsReport');
    	App::import('Model', 'CommissionsReportsTag');
        App::import('Model', 'InvoicesItemsCommissionsItem');
        App::import('Model', 'InvoicesItem');
        App::import('Model', 'Profile');
        App::import('Model', 'Invoice');
    	App::import('Controller', 'CommissionsReports');
    	$invModel = new InvoicesItem;
    	$invModel->delete_orphan_items();
    	exit;
    	// Generate Reminders
    	
    	$reminderModel = new Reminder;
    	$reminderModel->generate();
    	/////
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
