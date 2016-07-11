<?php
class MobileController extends AppController {

    var $name = 'Mobile';
    var $layout = 'default_jqmobile';

    var $uses = array();

    var $components = array(
    );

    function index() {

        $this->set('page_title', 'Home Page Music');
    }
    function m_index() {

        $this->set('page_title', 'Home Page Music');
    }
    function work() {

        $this->set('page_title', 'Work Sites');
    }
    function fades() {

    }

    function beforeFilter() {
        ;
    }
}
