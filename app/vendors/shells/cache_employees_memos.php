<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheEmployeesMemosShell extends Shell {

    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/employees_memo');
        $employeeMemoCacheModel = new EmployeesMemoCache;

        $employeeMemoCacheModel->cache_memos();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
