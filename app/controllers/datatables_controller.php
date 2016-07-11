<?php
class DatatablesController extends AppController {
    var $name = 'Datatables';
    var $layout = 'default_jqdatatables';

    var $uses = array();
    # test the menu scheme
    function index() {

    }
    function posts_index() {

    }


    function beforeFilter() {
        parent::BeforeFilter();
        $this->Auth->allowedActions = array('*', );
    }

}