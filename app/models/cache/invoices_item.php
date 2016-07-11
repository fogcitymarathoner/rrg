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
App::import('Model', 'InvoicesItem');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
class InvoicesItemCache extends InvoicesItem {


    private function sync($item,$fixfilename)
    {
        $xmlComp = new XmlComponent;

        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $xmlComp->serialize_invoice_item($item));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }


    }

    private function cache_bucket_of_items($items){

        $this->xml_home = Configure::read('xml_home');
        foreach ($items as $item)
        {
            $transdir = $this->xml_home.'transactions/';
            $xml_file_name =$transdir.'/invoices/invoice_items/'.str_pad((string)$item['InvoicesItem']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            $f = fopen($xml_file_name,'w');
            if( $f )
            {
                $this->sync($item, $xml_file_name);
                fclose($f);
            } else {
                echo 'could not open file '.$xml_file_name;
            }
        }
    }
    function cache_invoice_items($bucket) {
        ini_set('memory_limit', '-1');

        echo "Caching invoice items into transactions archive...\n";


        $this->recursive =1;
        $this->unbindModel(array('belongsTo' => array('Invoice'),),false);


        switch ($bucket)
        {
            case '1':
                $items = $this->find('all',array('conditions'=>array('id < 1000'),'order'=>array('InvoicesItem.id' =>'desc')));
                $this->cache_bucket_of_items($items);
                break;

            case '2':
                $items = $this->find('all',array('conditions'=>array('id > 999 and id < 2000'),'order'=>array('InvoicesItem.id' =>'desc')));

                $this->cache_bucket_of_items($items);
                break;
            case '3':
                $items = $this->find('all',array('conditions'=>array('id > 1999 and id < 3000'),'order'=>array('InvoicesItem.id' =>'desc')));

                $this->cache_bucket_of_items($items);
                break;
            case '4':
                $items = $this->find('all',array('conditions'=>array('id > 2999 and id < 4000'),'order'=>array('InvoicesItem.id' =>'desc')));

                $this->cache_bucket_of_items($items);
                break;
            case '4':
                $items = $this->find('all',array('conditions'=>array('id > 3999 and id < 5000'),'order'=>array('InvoicesItem.id' =>'desc')));

                $this->cache_bucket_of_items($items);
                break;
            case '4':
                $items = $this->find('all',array('conditions'=>array('id > 4999 and id < 6000'),'order'=>array('InvoicesItem.id' =>'desc')));

                $this->cache_bucket_of_items($items);
                break;
        }

    }
}