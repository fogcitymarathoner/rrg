#!/bin/bash


php cake/console/cake.php cache_employees
php cake/console/cake.php cache_employee_payments
php cake/console/cake.php cache_client_open_invoices
php cake/console/cake.php cache_contracts
php cake/console/cake.php delete_old_cleared_logs


