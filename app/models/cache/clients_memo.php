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
require_once dirname(__FILE__) . '/../../XML/Unserializer.php';
App::import('Model', 'ClientsMemo');
class ClientsMemoCache extends ClientsMemo {

    private function repair_dates($memo){

        /* repair dates if there are problems */
        $memosave = array();
        $memosave['ClientsMemo'] = $memo['ClientsMemo'];
        if($memo['ClientsMemo']['created_user_id']== Null)
            $memosave['ClientsMemo']['created_user_id'] =5;
        if($memo['ClientsMemo']['modified_user_id'] == Null)
            $memosave['ClientsMemo']['modified_user_id'] =5;
        if($memo['ClientsMemo']['modified_date'] == Null)
            $memosave['ClientsMemo']['modified_date']= date('Y-m-d H:i:s');
        if($memo['ClientsMemo']['created_date']    == Null)
            $memosave['ClientsMemo']['created_date']= date('Y-m-d H:i:s');
        $memosave['ClientsMemo']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($memosave);
    }
    private function sync($memo,$fixfilename)
    {
        if($f = fopen($fixfilename,'w+'))
        {
            fwrite($f, $this->xmlComp->serialize_client_memo($memo));
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
        echo "Syncing all Client memos \n";
        $memos = $this->find('all');
        $transdir = $this->xml_home.'clients/memos/';
        if (!file_exists($transdir)) {
            mkdir($transdir);
        }
        foreach($memos as $memo)
        {
            /*
             * repair and sync memos that were made before modified and created meta were automatically entered
             */
            $filename = $transdir.str_pad((string)$memo['ClientsMemo']['id'], 5, "0", STR_PAD_LEFT).'.xml';
			if(!file_exists (  $filename ) )
			{
				$this->sync($memo, $filename);
			}
            if ($memo['ClientsMemo']['modified_date'] == '0000-00-00 00:00:00' && 
				$memo['ClientsMemo']['last_sync_time'] == '0000-00-00 00:00:00')
            {
                $this->repair_dates($memo);
                $this->sync($memo,$filename);
            }
            if (strtotime($memo['ClientsMemo']['modified_date']) > strtotime($memo['ClientsMemo']['last_sync_time']))
            {
                $this->sync($memo,$filename);
            }
        }
    }
}

