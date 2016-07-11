<?php
class CacheEmployeeMemosShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/employees_memo');
        $employeesMemosModel = new EmployeesMemoCache;
        $employeesMemosModel->cache_memos();

        exit;
        // Generate Reminders
    }
}
