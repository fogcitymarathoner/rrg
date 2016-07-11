<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 5/9/2015
 * Time: 5:11 PM
 */

App::import('Model', 'State');


App::import('Component', 'FixtureDirectories');

App::import('Component', 'Xml');
class StateCache extends State
{

    //
    public function __construct()
    {
        $this->xml_home = Configure::read('xml_home');

        $this->dirComp = new FixtureDirectoriesComponent;

        $this->xmlComp = new XmlComponent;
        parent::__construct();
    }


    function cache_states() {

        echo "Caching states into archive...\n";
        ini_set('memory_limit', '-1');

        $this->unbindModel(array('hasMany' => array('Client', 'Employee', 'Vendor'),),false);
        $states = $this->find('all');

        /*
         *  Write JSON fixture for the Javascript apps
         */
        $f = fopen($this->xml_home.'states/states.xml','w');
        fwrite($f, $this->xmlComp->serialize_states($states));
        fclose($f);
    }

}