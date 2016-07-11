<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 12/4/13
 * Time: 2:14 PM
 * To change this template use File | Settings | File Templates.
 */
//require_once("XML/Serializer.php");
//require_once("XML/Unserializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';
require_once dirname(__FILE__) . '/../../XML//Unserializer.php';
App::import('Model', 'Profile');
App::import('Component', 'Xml');
App::import('Component', 'Json');
class ProfileCache extends Profile {


    function cache_profiles() {
        ini_set('memory_limit', '-1');

        $xmlComp = new XmlComponent;
        $this->xml_home = Configure::read('xml_home');
        echo "Caching profiles into archive...\n";


        $this->unbindModel(array('belongsTo' => array('Employee','User'),),false);
        $items = $this->find('all');


        $pdir = $this->xml_home.'employees/profiles/';
        if (!file_exists($pdir)) {
            mkdir($pdir, 0777);
            echo "The directory $pdir was successfully created.";
            exit;
        } else {
            echo "The directory $pdir exists.";
        }
        foreach ($items as $item)
        {
            $filename = $pdir.str_pad((string)$item['Profile']['id'], 5, "0", STR_PAD_LEFT).'.xml';

            if($f = fopen($filename,'w'))
            {
                fwrite($f, $xmlComp->serialize_profile($item));
                fclose($f);
            } else {
                print "could not open ".$filename;
            }
        }
    }
}