<?php
// vendors/shells/demo.php
class DemoShell extends Shell {
	var $uses = array('Employee');
	
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
    	App::import('Model', 'CommissionsReportsTagsItem');
    	App::import('Controller', 'CommissionsReports');
    	$commItemsModel = new CommissionsReportsTagsItem;
    	$commItemsModel->shell_copy_uncleared();
    	exit;
    	// Generate Reminders
    	
    	$reminderModel = new Reminder;
    	$reminderModel->generate();
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
