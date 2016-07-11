<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 7/26/2015
 * Time: 12:37 PM
 */


App::import('Model', 'Vendor');

class VendorCache extends Vendor {




    /*
     * Write fixture down mark client as synced
     */
    private function sync($vendor,$fixfilename)
    {
        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $this->xmlComp->serialize_vendor($vendor));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $clsave = array();
        $clsave['Vendor'] = $vendor['Vendor'];

        /* repair dates if there are problems */
        if($vendor['Vendor']['created_user_id']== Null)
            $clsave['Vendor']['created_user_id'] =5;
        if($vendor['Vendor']['modified_user_id'] == Null)
            $clsave['Vendor']['modified_user_id'] =5;
        if($vendor['Vendor']['modified_date'] == Null)
            $clsave['Vendor']['modified_date']= date('Y-m-d H:i:s');
        if($vendor['Vendor']['created_date']    == Null)
            $clsave['Vendor']['created_date']= date('Y-m-d H:i:s');

        $clsave['Vendor']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($clsave);
    }
    function cache_vendors() {

        echo "Caching vendors into archive...\n";
        ini_set('memory_limit', '-1');

        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));

        $vendors = $this->find('all');
        $vendorsJS  = array();
        $vendorsJS['vendors']  = array();

        foreach ($vendors as $vendor)
        {
            $vendorsJS['vendors'][$vendor['Vendor']['id']] = array('id'=>$vendor['Vendor']['id'],'name'=>$vendor['Vendor']['name'],'active'=>$vendor['Vendor']['active']);
            $vendorssdir = $this->xml_home.'vendors/';
            $filename = $vendorssdir.str_pad((string)$vendor['Vendor']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            echo "Caching vendor ".$vendor['Vendor']['name']."  into archive ".$filename."...\n";
            if(count($vendor['VendorsMemo'])){

                $this->cache_vendor_memos($vendor);
            }
            if(!file_exists (  $filename ) )
            {
                $this->sync($vendor,$filename);
            }
            else
            {
                if (strtotime($vendor['Vendor']['modified_date']) > strtotime($vendor['Vendor']['last_sync_time']))
                {
                    $this->sync($vendor,$filename);
                }
            }
        }

    }


    function cache_vendor_memos($vendor) {

        echo "Caching vendor ".$vendor['Vendor']['name']." memos into archive...\n";
        ini_set('memory_limit', '-1');

        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));

        $filename = $this->vendorsmemosdir.str_pad((string)$vendor['Vendor']['id'], 5, "0", STR_PAD_LEFT).'.xml';

        if(!file_exists ($filename)){
            print "Vendor memo file ".$filename." does not exist.\n";
            if ($f = fopen($filename, 'w')) {
                fwrite($f, $this->xmlComp->serialize_vendor_memos($vendor));
                fclose($f);
                foreach($vendor['VendorsMemo'] as $memo){

                    $clsave = array();
                    $clsave['VendorsMemo'] = $memo;

                    /* repair dates if there are problems */
                    if($memo['created_user_id']== Null)
                        $clsave['VendorsMemo']['created_user_id'] =5;
                    if($memo['modified_user_id'] == Null)
                        $clsave['VendorsMemo']['modified_user_id'] =5;
                    if($memo['modified_date'] == Null)
                        $clsave['VendorsMemo']['modified_date']= date('Y-m-d H:i:s');
                    if($memo['created_date']    == Null)
                        $clsave['VendorsMemo']['created_date']= date('Y-m-d H:i:s');
                    $clsave['VendorsMemo']['last_sync_time'] = date('Y-m-d H:i:s');
                    $this->VendorsMemo->save($clsave);
                }
            } else {
                print "could not open ".$filename;
            }

        } else {
            print "Vendor memo file ".$filename." exists.\n";


            $doc = new DOMDocument('1.0');
            $doc->formatOutput = true;
            // We don't want to bother with white spaces
            $doc->preserveWhiteSpace = false;

            $xml = $doc->load($filename);
            foreach($vendor['VendorsMemo'] as $memo){

                $xpath = new DOMXPath($doc);

                // Search for note of db id
                $query = "/memos/memo/id[.='".$memo['id']."']";
                $vendor_memos_cached = $xpath->query($query);

                if($vendor_memos_cached->length == 0){
                    // add memo to xml cache, it's new
                    debug($memo['id'].' is a new memo???');
                    $this->xmlComp->serialize_vendor_memo($doc, $memo);
                    if ($f = fopen($filename, 'w')) {
                        fwrite($f, $doc->saveXML());
                        fclose($f);
                    } else {
                        print "could not open ".$filename;
                    }

                } else {
                    // check database for sync condition

                    if( strtotime($memo['modified_date']) > strtotime($memo['last_sync_time']))
                    {
                        print 'deleting and refilling '.$filename;
                        unlink($filename);
                        if ($f = fopen($filename, 'w')) {
                            fwrite($f, $this->xmlComp->serialize_vendor_memos($vendor));
                            fclose($f);
                            foreach($vendor['VendorsMemo'] as $memo){

                                $clsave = array();
                                $clsave['VendorsMemo'] = $memo;

                                /* repair dates if there are problems */
                                if($memo['created_user_id']== Null)
                                    $clsave['VendorsMemo']['created_user_id'] =5;
                                if($memo['modified_user_id'] == Null)
                                    $clsave['VendorsMemo']['modified_user_id'] =5;
                                if($memo['modified_date'] == Null)
                                    $clsave['VendorsMemo']['modified_date']= date('Y-m-d H:i:s');
                                if($memo['created_date']    == Null)
                                    $clsave['VendorsMemo']['created_date']= date('Y-m-d H:i:s');
                                $clsave['VendorsMemo']['last_sync_time'] = date('Y-m-d H:i:s');
                                $this->VendorsMemo->save($clsave);

                            }
                            break;
                        } else {
                            print "could not open ".$filename;
                        }
                    }
                }
            }
        }
    }


}