<?php
class MootestController extends AppController {
    var $name = 'Mootest';
    var $layout = 'default_moomenu';

    var $uses = array();
    # test the menu scheme
    function index() {

    }
    function daterange() {
        $this->layout = 'default_moodaterange';
    }



}