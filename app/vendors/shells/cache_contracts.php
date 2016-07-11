<?php
class CacheContractsShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/clients_contract');
        $contractModel = new ClientsContractCache;
        $contractModel->cache_contracts();
        exit;
    }
}
