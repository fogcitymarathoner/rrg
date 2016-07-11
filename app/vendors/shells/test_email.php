<?php
// vendors/shells/demo.php
class TestEmailShell extends Shell {
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
    	App::import('Component', 'Email');
    	$email = new EmailComponent;
    	$email->send();
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
