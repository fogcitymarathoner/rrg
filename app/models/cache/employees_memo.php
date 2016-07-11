<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/9/14
 * Time: 6:01 PM
 */
//require_once("XML/Serializer.php");
//require_once("XML/Unserializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';
require_once dirname(__FILE__) . '/../../XML//Unserializer.php';
App::import('Model', 'EmployeesMemo');
App::import('Component', 'Xml');
App::import('Component', 'Json');
class EmployeesMemoCache extends EmployeesMemo {

    private function repair_dates($memo){

        /* repair dates if there are problems */
        $memosave = array();
        $memosave['EmployeesMemo'] = $memo['EmployeesMemo'];
        if($memo['EmployeesMemo']['created_user_id']== Null)
            $memosave['EmployeesMemo']['created_user_id'] =5;
        if($memo['EmployeesMemo']['modified_user_id'] == Null)
            $memosave['EmployeesMemo']['modified_user_id'] =5;
        if($memo['EmployeesMemo']['modified_date'] == Null)
            $memosave['EmployeesMemo']['modified_date']= date('Y-m-d H:i:s');
        if($memo['EmployeesMemo']['created_date']    == Null)
            $memosave['EmployeesMemo']['created_date']= date('Y-m-d H:i:s');
        $memosave['EmployeesMemo']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($memosave);
    }
    private function sync($memo,$fixfilename)
    {
        $xmlComp = new XmlComponent;
        if($f = fopen($fixfilename,'w+'))
        {
            fwrite($f, $xmlComp->serialize_employee_memo($memo));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }

    }

    /*
     *  Cache All Memos
     */
    function cache_memos()
    {
        $threeWeeksBack = mktime(0, 0, 0, date("m")  , date("d")-21,date("Y"));
        ini_set('memory_limit', '-1');
        echo "Syncing all memos \n";

        $memos = $this->find('all');
        $this->xml_home = Configure::read('xml_home');
        $transdir = $this->xml_home.'employees_memos/';
        if (!file_exists($transdir)) {
            mkdir($transdir);
        }
        foreach($memos as $memo)
        {
            /*
             * repair and sync memos that were made before modified and created meta were automatically entered
             */
            $filename = $transdir.str_pad((string)$memo['EmployeesMemo']['id'], 5, "0", STR_PAD_LEFT).'.xml';
			if(!file_exists (  $filename ) )
			{
				$this->sync($memo, $filename);
			}
            if ($memo['EmployeesMemo']['modified_date'] == '0000-00-00 00:00:00' && 
				$memo['EmployeesMemo']['last_sync_time'] == '0000-00-00 00:00:00')
            {
                $this->repair_dates($memo);
                $this->sync($memo,$filename);
            }
            if (strtotime($memo['EmployeesMemo']['modified_date']) > strtotime($memo['EmployeesMemo']['last_sync_time']))
            {
                $this->sync($memo,$filename);
            }
        }
    }
}

