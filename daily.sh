#!/bin/bash
# todo: replace with fabric routines, move out of nginx container and into cake-rrg container
# or just run generate_reminders

fab cache_comm_items:data_dir=data/transactions/invoices/invoice_items/commissions_items/
fab cache_client_accounts_receivable:data_dir=data/transactions/invoices/invoice_items/commissions_items/
php cake/console/cake.php delete_old_voided_invoices
php cake/console/cake.php delete_old_zeroed_invoice_items
php cake/console/cake.php generate_reminders
php cake/console/cake.php cache_reminders
php cake/console/cake.php cache_invoices 1
php cake/console/cake.php cache_invoices 2
php cake/console/cake.php cache_invoices 3
php cake/console/cake.php cache_invoices 4
php cake/console/cake.php cache_invoice_items 1
php cake/console/cake.php cache_invoice_items 2
php cake/console/cake.php cache_invoice_items 3
php cake/console/cake.php cache_invoice_items 4
php cake/console/cake.php cache_invoice_items 5
php cake/console/cake.php cache_invoice_items 6
php cake/console/cake.php cache_checks
php cake/console/cake.php cache_payrolls
php cake/console/cake.php cache_employees
php cake/console/cake.php cache_client_open_invoices
php cake/console/cake.php cache_employee_payments
php cake/console/cake.php cache_clients
php cake/console/cake.php cache_contracts
php cake/console/cake.php delete_old_cleared_logs
php cake/console/cake.php delete_orphan_invoice_items

# source /home/marc/envs/boto/bin/activate && fab db_backup
