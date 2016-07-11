<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/9/14
 * Time: 6:01 PM
 */

App::import('Model', 'ClientsManager');
class ClientsManagerCache extends ClientsManager
{

    private function repair_dates($memo){

        /* repair dates if there are problems */
        $memosave = array();
        $memosave['ClientsManager'] = $memo['ClientsManager'];
        if($memo['ClientsManager']['created_user_id']== Null)
            $memosave['ClientsManager']['created_user_id'] =5;
        if($memo['ClientsManager']['modified_user_id'] == Null)
            $memosave['ClientsManager']['modified_user_id'] =5;
        if($memo['ClientsManager']['modified_date'] == Null)
            $memosave['ClientsManager']['modified_date']= date('Y-m-d H:i:s');
        if($memo['ClientsManager']['created_date']    == Null)
            $memosave['ClientsManager']['created_date']= date('Y-m-d H:i:s');
        $memosave['ClientsManager']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($memosave);
    }
    private function sync($manager,$fixfilename)
    {
        if($f = fopen($fixfilename,'w+'))
        {
            fwrite($f, $this->xmlComp->serialize_client_manager($manager));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }

    }

    /*
     *  Cache All Managers
     */
    function cache_managers()
    {

        ini_set('memory_limit', '-1');
        echo "Syncing all Client managers \n";
        $managers = $this->find('all');
        $transdir = $this->xml_home.'clients/managers/';

        foreach($managers as $manager)
        {
            /*
             * repair and sync memos that were made before modified and created meta were automatically entered
             */
            $filename = $transdir.str_pad((string)$manager['ClientsManager']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            if(!file_exists (  $filename ) )
            {
                $this->sync($manager, $filename);
            }
            if ($manager['ClientsManager']['modified_date'] == '0000-00-00 00:00:00' &&
                $manager['ClientsManager']['last_sync_time'] == '0000-00-00 00:00:00')
            {
                $this->repair_dates($manager);
                $this->sync($manager,$filename);
            }
            if (strtotime($manager['ClientsManager']['modified_date']) > strtotime($manager['ClientsManager']['last_sync_time']))
            {
                $this->sync($manager,$filename);
            }
        }
    }

}