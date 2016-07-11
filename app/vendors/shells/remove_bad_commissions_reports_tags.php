<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class RemoveBadCommissionsReportsTagsShell extends Shell {
    var $uses = array('Employee');

    function initialize() {
        // empty
    }

    function main() {


        App::import('Model', 'Employee');
        $employeeModel = new Employee;

        print "beginning of process\n";
        $employeeModel->remove_non_sales_taggedreports();
        print 'end of process';
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
