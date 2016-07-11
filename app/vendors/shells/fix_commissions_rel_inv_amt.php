<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class FixCommissionsRelInvAmtShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {
    	
    	App::import('Controller', 'App');
    	App::import('Model', 'Employee');
    	App::import('Controller', 'Employees');
        App::import('Model', 'Reminder');
        App::import('Model', 'Invoice');
    	App::import('Model', 'CommissionsReport');
    	App::import('Model', 'CommissionsReportsTag');
        App::import('Model', 'InvoicesItemsCommissionsItem');
        App::import('Model', 'Profile');
    	App::import('Controller', 'CommissionsReports');
    	$invM = new InvoicesItemsCommissionsItem;
        $invM->fix_commitems();
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
