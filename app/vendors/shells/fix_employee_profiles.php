<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class FixEmployeeProfilesShell extends Shell {
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
        App::import('Model', 'Profile');
    	App::import('Controller', 'CommissionsReports');
    	$employeesController = new EmployeesController;
    	$profileModel = new Profile;
    	$commissionsReportModel = new CommissionsReport;
    	$commReportTagModel = new CommissionsReportsTag;
    	//$commReportTagModel->shell_generate_tags();
    	$profileModel->fix_profiles();
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
