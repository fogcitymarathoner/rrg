<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheClientsArShell extends Shell {
    #var $uses = array('Employee');

    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/client');
        $clientCacheModel = new ClientCache;

        $clientCacheModel->cache_clients_ar();
        $clientCacheModel->cache_invoices();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
