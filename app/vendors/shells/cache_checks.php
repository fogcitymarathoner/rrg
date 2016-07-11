<?php
class  CacheChecksShell extends Shell {
    function initialize() {
        // empty
    }
    function main() {
        Configure::write('debug',2);
        //ini_set('display_errors',1);
        //error_reporting(E_ALL);
        App::import('Model', 'cache/clients_check');
        $checksModel = new ClientsCheckCache;
        $checksModel->cache_checks();
    	exit;
    }
    function help() {
        $this->out('Here comes the help message');
    }
}