<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 12/4/13
 * Time: 2:14 PM
 * To change this template use File | Settings | File Templates.
 */

App::import('Model', 'ClientsCheck');
class ClientsCheckCache extends ClientsCheck {

    private function sync($check, $fixfilename)
    {
        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $this->xmlComp->serialize_clients_check($check));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $cksave = array();
        $cksave['ClientsCheck'] = $check['ClientsCheck'];
        if($check['ClientsCheck']['created_user_id']== Null)
            $cksave['ClientsCheck']['created_user_id'] =5;
        if(!isset($check['ClientsCheck']['modified_user_id'] ))
            $cksave['ClientsCheck']['modified_user_id'] =5;
        if(!isset($check['ClientsCheck']['modified_date'] ))
            $cksave['ClientsCheck']['modified_date']= date('Y-m-d H:i:s');
        if($check['ClientsCheck']['created_date']    == Null)
            $cksave['ClientsCheck']['created_date']= date('Y-m-d H:i:s');
        $cksave['ClientsCheck']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($cksave);
    }
    function cache_checks() {
        Configure::write('debug',2);
        ini_set('memory_limit', '-1');
        echo "Caching checks into transactions archive...\n";
        $this->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('belongsTo' => array('Client'),),false);
        $checks = $this->find('all');
        $transdir = $this->xml_home.'transactions/';
        foreach ($checks as $check)
        {
            $filename = $transdir.'checks/'.str_pad((string)$check['ClientsCheck']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            echo "syncing file ".$filename."\n";
            if(!file_exists ($filename) )
            {
                $this->sync($check, $filename);
            }
            else
            {
                if (isset($check['ClientsCheck']['modified_date']) && strtotime($check['ClientsCheck']['modified_date']) > strtotime($check['ClientsCheck']['last_sync_time']))
                {
                    $this->sync($check, $filename);
                }
            }
        }
    }
}