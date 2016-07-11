<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheExpensesShell extends Shell {

    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/expense');
        $expenseCacheModel = new ExpenseCache;

        $expenseCacheModel->cache_expenses();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
