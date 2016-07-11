<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheVendorsShell extends Shell {

    function initialize() {
        // empty
    }

    function main() {
        App::import('Model', 'cache/vendor');
        $vendorCacheModel = new VendorCache;

        $vendorCacheModel->cache_vendors();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
