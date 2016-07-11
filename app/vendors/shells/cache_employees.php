<?php
class CacheEmployeesShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/employee');
        App::import('Model', 'cache/profile');
        $employeesModel = new EmployeeCache;
        $profileModel = new ProfileCache;
        $employeesModel->cache_employees();
        $profileModel->cache_profiles();
        exit;
        // Generate Reminders
    }
}
