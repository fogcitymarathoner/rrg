<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 4/17/13
 * Time: 10:16 PM
 * To change this template use File | Settings | File Templates.
 */

class  BuildAclShell extends Shell {
    function initialize() {
        // empty
    }
    function main() {
        Configure::write('debug',2);
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        #App::import('Model', 'ClientsCheck');
        #$checksModel = new ClientsCheck;
        #$checksModel->cache_checks();
        exit;
    }
    function help() {
        $this->out('Here comes the help message');
    }
}