<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheClientsShell extends Shell {

    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/client');
        $clientCacheModel = new ClientCache;

        $clientCacheModel->cache_clients();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
