<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheStatesShell extends Shell {
    #var $uses = array('Employee');

    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/state');
        $stateCacheModel = new StateCache;

        $stateCacheModel->cache_states();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
