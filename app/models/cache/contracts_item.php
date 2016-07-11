<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/23/14
 * Time: 1:42 PM
 */

App::import('Model', 'ContractsItem');
class ContractsItemCache extends ContractsItem
{
    private function sync($item, $fixfilename)
    {
        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $this->xmlComp->serialize_contract_items($item));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $cksave = array();
        $cksave['ContractsItem'] = $item['ContractsItem'];
        if($item['ContractsItem']['created_user_id']== Null)
            $cksave['ContractsItem']['created_user_id'] =5;
        if(!isset($item['ContractsItem']['modified_user_id'] ))
            $cksave['ContractsItem']['modified_user_id'] =5;
        if(!isset($item['ContractsItem']['modified_date'] ))
            $cksave['ContractsItem']['modified_date']= date('Y-m-d H:i:s');
        if($item['ContractsItem']['created_date']  == Null)
            $cksave['ContractsItem']['created_date']= date('Y-m-d H:i:s');
        $cksave['ContractsItem']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($cksave);
    }
    public function cache_items(){
        ini_set('memory_limit', '-1');

        $items = $this->find('all');
        echo "Caching contract items ...\n";
        foreach ($items as $item)
        {
            $itemsdir = $this->xml_home.'contracts/contracts_items/';
            $filename = $itemsdir.str_pad((string)$item['ContractsItem']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            echo 'Processing '.$filename."\n";
            if(!file_exists ($filename) )
            {
                $this->sync($item, $filename);
            }
            else
            {
                if (isset($item['ContractsItem']['modified_date']) &&
                    strtotime($item['ContractsItem']['modified_date']) > strtotime($item['ContractsItem']['last_sync_time']))
                {
                    $this->sync($item, $filename);
                }
            }
        }
    }

}