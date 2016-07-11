<?php
class CacheClientManagersShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/clients_manager');
        $clientsMemosModel = new ClientsManagerCache;
        $clientsMemosModel->cache_managers();

        exit;
        // Generate Reminders
    }
}
