#!/bin/bash
php cake/console/cake.php cache_employees
php cake/console/cake.php cache_invoice_items
php cake/console/cake.php cache_invoice_commissions_items
php cake/console/cake.php cache_checks
php cake/console/cake.php cache_payrolls
php cake/console/cake.php cache_employees
php cake/console/cake.php cache_vendors
php cake/console/cake.php cache_employee_payments
php cake/console/cake.php cache_clients
php cake/console/cake.php delete_orphan_invoice_items
php cake/console/cake.php delete_old_cleared_logs
php cake/console/cake.php delete_old_voided_invoices
php cake/console/cake.php delete_old_zeroed_invoice_items
php cake/console/cake.php cache_contracts
php cake/console/cake.php cache_employee_commissions_payments

