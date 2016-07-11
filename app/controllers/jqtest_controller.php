<?php
class JqtestController extends AppController {

    var $name = 'Jqtest';
    var $layout = 'default_jqmenu_jq1.8.2';
    var $uses = '';

	function index() {
        $this->layout = 'default_jq_jq1.8.2_original';
    }

    function datepicker_test() {
        $this->layout = 'default_jqmenu_jq1.8.2';
    }

    function menu_test() {
        ;
    }
}