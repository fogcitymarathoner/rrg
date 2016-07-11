<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class GenerateTagReportsShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {

    	App::import('Model', 'commissions/employee');

        $employeeModel = new EmployeeCommissions;
    	$employeeModel->generatetaggedreports();
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
