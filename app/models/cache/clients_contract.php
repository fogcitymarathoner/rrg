<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 12/4/13
 * Time: 5:54 PM
 * To change this template use File | Settings | File Templates.
 */


App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Model', 'ClientsContract');
class ClientsContractCache extends ClientsContract {

    private function repair_dates($pay){

        /* repair dates if there are problems */
        $paysave = array();
        $paysave['ClientsContract'] = $pay['v'];
        if($pay['ClientsContract']['created_user_id']== Null)
            $paysave['ClientsContract']['created_user_id'] =5;
        if($pay['ClientsContract']['modified_user_id'] == Null)
            $paysave['ClientsContract']['modified_user_id'] =5;
        if($pay['ClientsContract']['modified_date'] == Null)
            $paysave['ClientsContract']['modified_date']= date('Y-m-d H:i:s');
        if($pay['ClientsContract']['created_date']    == Null)
            $paysave['ClientsContract']['created_date']= date('Y-m-d H:i:s');
        $paysave['v']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($paysave);
    }
    /*
     * Write fixture down mark contract as synced
     */
    private function sync($contract,$fixfilename)
    {
        $xmlComp = new XmlComponent;
        echo 'Writing '.$fixfilename."\n";
        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $xmlComp->serialize_contract($contract));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $clsave = array();
        $clsave['Client'] = $contract['ClientsContract'];

        /* repair dates if there are problems */
        if($contract['ClientsContract']['created_user_id']== Null)
            $clsave['ClientsContract']['created_user_id'] =5;
        if($contract['ClientsContract']['modified_user_id'] == Null)
            $clsave['ClientsContract']['modified_user_id'] =5;
        if($contract['ClientsContract']['modified_date'] == Null)
            $clsave['ClientsContract']['modified_date']= date('Y-m-d H:i:s');
        if($contract['ClientsContract']['created_date']    == Null)
            $clsave['ClientsContract']['created_date']= date('Y-m-d H:i:s');

        $clsave['Client']['last_synced_time'] = date('Y-m-d H:i:s');
        $this->save($clsave);
    }


    function cache_contracts_xml() {

        echo "Caching contracts into archive...\n";
        ini_set('memory_limit', '-1');

        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $this->unbindModel(array('belongsTo' => array('Employee','Client','Period'),),false);
        $this->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $contracts = $this->find('all');

        foreach ($contracts as $contract)
        {
            $clientssdir = $this->xml_home.'contracts/';
            $filename = $clientssdir.str_pad((string)$contract['ClientsContract']['id'], 5, "0", STR_PAD_LEFT).'.xml';

            if(!file_exists (  $filename ) )
            {
                $this->sync($contract,$filename);
            }
            else
            {
                if (strtotime($contract['ClientsContract']['modified_date']) > strtotime($contract['ClientsContract']['last_sync_time']))
                {
                    $this->sync($contract,$filename);
                }
            }
        }

    }
    function cache_contracts() {
        /*
         * this is the json dump for the coffeescript app
         */
        Configure::write('debug',2);

        $this->unbindModel(array('belongsTo' => array('Employee','Client','Period'),),false);
        $this->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->User->unbindModel(array('hasOne' => array('Profile'),),false);
        $this->recursive = 2;
        echo "Caching contracts into json fixture ...\n";
        $contracts = $this->find('all');
        $contracts['date_generated'] = date('D, d M Y H:i:s');
        $this->xml_home = Configure::read('xml_home');
        $jsonComp = new JsonComponent;
        if (!file_exists($this->xml_home.'contracts/')) {
            mkdir($this->xml_home.'contracts/');
        }
        $f = fopen($this->xml_home.'contracts/contracts.json','w');
        fwrite($f,$jsonComp->contracts_jquery($contracts));
        fclose($f);
        $this->cache_contracts_xml();
    }
}