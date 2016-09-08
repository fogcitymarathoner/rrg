<?php
class DecryptEmployeesShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/employee');
        
        $employeesModel = new EmployeeCache;

        $employeesModel->decrypt();
        exit;
        // Generate Reminders
    }
}
