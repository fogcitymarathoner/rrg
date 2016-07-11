<?php
class CacheEmployeePaymentsShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/employees_payment');
        $employeesPaymentsModel = new EmployeesPaymentCache;
        $employeesPaymentsModel->cache_payments();

        exit;
        // Generate Reminders
    }
}
