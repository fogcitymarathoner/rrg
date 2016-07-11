<?php
class CacheClientMemosShell extends Shell {
    var $uses = array('Employee');
    function initialize() {
        // empty
    }
    function main() {
        App::import('Model', 'cache/clients_memo');
        $clientsMemosModel = new ClientsMemoCache;
        $clientsMemosModel->cache_memos();

        exit;
        // Generate Reminders
    }
}
