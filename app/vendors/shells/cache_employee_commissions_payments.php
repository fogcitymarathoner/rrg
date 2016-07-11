<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/14/14
 * Time: 9:58 PM
 */


//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheEmployeeCommissionsPaymentsShell extends Shell {
    var $uses = array('Employee');

    function initialize() {
        // empty
    }

    function main() {

        App::import('Model', 'cache/commissions_payment');

        echo "Caching commissions payments\n";
        $paymentModel = new CommissionsPaymentCache;

        $paymentModel->cache_payments();
        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
