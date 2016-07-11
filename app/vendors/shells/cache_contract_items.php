<?php
class CacheContractItemsShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/contracts_item');
        $contractsItemModel = new ContractsItemCache;
        $contractsItemModel->cache_items();
        exit;
        // Generate Reminders
    }
}
