<?php
/*
 *  Link opening Commissions items to Invoice items and Invoices
 *     `invoices_items_commissions_items` opening = True, ItemId = 0
 *
 * Make sure Employee delete method deletes Invoice and Invoice Item
 *
 * Make sure new Employee fills in OpeningInvoiceID
 *
 *
 */
App::import('Model', 'Client');
App::import('Model', 'Invoice');
class ClientCache extends Client {
    /*
     * Write fixture down mark client as synced
     */
    private function sync($client,$fixfilename)
    {
        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $this->xmlComp->serialize_client($client));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $clsave = array();
        $clsave['Client'] = $client['Client'];

        /* repair dates if there are problems */
        if($client['Client']['created_user']== Null)
            $clsave['Client']['created_user'] =5;
        if($client['Client']['modified_user'] == Null)
            $clsave['Client']['modified_user'] =5;
        if($client['Client']['modified_date'] == Null)
            $clsave['Client']['modified_date']= date('Y-m-d H:i:s');
        if($client['Client']['created_date']    == Null)
            $clsave['Client']['created_date']= date('Y-m-d H:i:s');

        $clsave['Client']['last_synced_time'] = date('Y-m-d H:i:s');
        $this->save($clsave);
    }
    /*
    * collects primary keys of posted invoices of client's
    */
    private function invoices_all($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->ClientsCheck->InvoicesPayment->unbindModel(array('belongsTo' => array('Invoice','ClientsCheck'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsManager','ClientsMemo','ClientsSearch',),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('hasMany' => array('ContractsItem'),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('User'),),false);
        $this->ClientsContract->Invoice->bindModel(array('belongsTo' => array('ClientsContract'),),false);
        $this->data = $this->read(null, $id);
        $this->ClientsContract->Invoice->recursive = 2;
        $Invoice = new Invoice;
        $invoices = $Invoice->find('all',
            array('order' =>'date DESC',
                'conditions'=>array('client_id'=>$id,
                    'Invoice.voided'=>0,'Invoice.posted'=>1,'Invoice.amount > 0'),
                array('order'=>array('date desc'))
            ));
        $res = array();
        $count = 0;
        foreach ($invoices as $invoice):
            if(!$invoice['Invoice']['voided']) # only go through expense of calculating 'cleared' or 'pastdue' if not cleared
            {
                $res[] = $invoice['Invoice']['id'];
            }
            $count++;
        endforeach;
        return ($res);
    }

    /*
     * collects primary keys of client's checks
     */
    private function checks_all($id = null)
    {

        $checks = Array();
        $checksDB = $this->ClientsCheck->find('all',array('conditions'=>array('client_id'=>$id)));
        foreach ($checksDB as $check)
        {
            // set cleared [4] and voided [7] to zero
            $checks [] = $check['ClientsCheck']['id'];
        }
        return $checks;
    }
    function open_invoices_client($client_id)
    {
        $this->recursive = 2;
        $this->Invoice->unbindContractModelForInvoicing();
        $this->Invoice->unbindModel(array('hasMany' =>
            array(
                'InvoicesItem',
                'InvoicesPayment',
                'EmployeesPayment',
                'ClientsManager'),),false);

        $this->ClientsContract->Client->unbindModel(array('hasMany' => array(
            'ClientsManager',
        ),),false);

        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array(
            'ClientsManager',
        ),),false);
        $open = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,
                    'cleared'=>0,
                    'posted'=>1,
                    'mock' => 0,
                    'amount >0','client_id'=>$client_id),
                'fields'=>array(
                    'Invoice.id',
                    'Invoice.period_start',
                    'Invoice.period_end',
                    'Invoice.date',
                    'Invoice.terms',
                    'Invoice.notes',
                    'Invoice.amount',
                    'Invoice.contract_id',
                    'Invoice.voided',
                    'ClientsContract.employee_id'),
                'order'=>array('Invoice.date DESC')
            )
        );
        $count = 0;
        foreach ($open as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
            $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
            $open[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
            $open[$count]['Invoice']['dayspast'] = $this->dateF->dateDiff(date('Y-m-d',$duedate),date('Y-m-d',$today));
            if ($duedate < mktime(0, 0, 0, date("m")  , date("d"), date("Y")))
            {
                $open[$count]['Invoice']['pastdue'] = 1;
            } else
            {
                $open[$count]['Invoice']['pastdue'] = 0;
            }
            $count++;
        endforeach;
        return $open;
    }

    function cleared_invoices_client($client_id)
    {
        $this->Invoice->unbindContractModelForInvoicing();
        $this->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog','ClientsManager'),),false);
        $this->Client->unbindModel(array('hasMany' => array('ClientsManager', ),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager',),),false);
        $cleared = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,'posted'=>1,'cleared'=>1,'client_id'=>$client_id,
                    'mock' => 0,),
                'fields'=>array(
                    'Invoice.id',
                    'Invoice.period_start',
                    'Invoice.period_end',
                    'Invoice.date',
                    'Invoice.terms',
                    'Invoice.notes',
                    'Invoice.amount',
                    'Invoice.contract_id',
                    'ClientsContract.employee_id'),
                'order'=>array('Invoice.date ASC'),
            )
        );
        $count = 0;
        foreach ($cleared as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))   , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
            $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
            $cleared[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
            $count++;
        endforeach;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'
        ,'ClientsManager'),),false);
        return $cleared;
    }

    function cache_clients_ar() {
        Configure::write('debug',2);
        echo "Caching clients accounts receivables into archive...\n";
        ini_set('memory_limit', '-1');

        $ar  = array();
        $ar['all'] = array();
        $ar['open'] = array();
        $ar['pastdue'] = array();
        $ar['cleared'] = array();
        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $this->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsCheck','ClientsSearch'),),false);
        $this->Client = new Client;

        $clients = $this->Client->find('all');
        $clientsJS  = array();
        $clientsJS['clients']  = array();

        $this->ClientsContract = new ClientsContract;
        $this->Invoice = new Invoice;
        foreach ($clients as $client)
        {

            echo " ".$client['Client']['name']."\n";
            $cleared = $this->cleared_invoices_client($client['Client']['id']);
            $open  = $this->open_invoices_client($client['Client']['id']);

            foreach ($open as $inv)
            {
                if( $inv['Invoice']['pastdue'] == 1)
                {
                    $ar['pastdue'][] = $inv['Invoice']['id'];
                }
                $ar['all'][] = $inv['Invoice']['id'];
                $ar['open'][] = $inv['Invoice']['id'];
            }
            foreach ($cleared as $inv)
            {
                $ar['all'][] = $inv['Invoice']['id'];
                $ar['cleared'][] = $inv['Invoice']['id'];
            }
        }
        $filename = $this->xml_home.'transactions/invoices/ar.xml';
        echo 'Writing AR report to '.$filename."\n";
        $ar['date_generated'] = date('D, d M Y H:i:s');
        $f = fopen($filename,'w');
        fwrite($f, $this->xmlComp->serialize_ar($ar));
        fclose($f);

        $this->cache_client_open_invoices();
    }

    private function append_new_transactions_to_statement_array($payload,$invoicesdb, $checksdb)
    {
        $newpayload = array();
        $newpayload['Invoice'] = array();
        $newpayload['Check'] = array();
        // recollect previous invoices
        if(!empty($payload['Invoice']['XML_Serializer_Tag']) )
        {
            $inv_count = count($payload['Invoice']['XML_Serializer_Tag']);
            foreach ($payload['Invoice']['XML_Serializer_Tag'] as $inv)
            {
                // remove phoney invoice
                if ($inv != 0  )
                {
                    $newpayload['Invoice'][] = $inv;
                } else if ($inv_count == 1){
                    $newpayload['Invoice'][] = $inv;
                }
            }
        }
        // recollect previous checks
        if(!empty($payload['Check']['XML_Serializer_Tag']))
        {
            $inv_count = count($payload['Check']['XML_Serializer_Tag']);
            foreach ($payload['Check']['XML_Serializer_Tag'] as $inv)
            {
                // remove phoney check
                if ($inv != 0  )
                {
                    $newpayload['Check'][] = $inv;
                } else if ($inv_count == 1){
                    $newpayload['Check'][] = $inv;
                }
            }
        }
        // add new invoices to statement
        foreach ($invoicesdb['Invoice'] as $inv)
        {
            if(!in_array($inv,$newpayload['Invoice']))
            {
                $newpayload['Invoice'][] = $inv;
            }
        }
        // add new invoices to statement
        foreach ($checksdb['Check'] as $ck)
        {
            if(!in_array($ck,$newpayload['Check']))
            {
                $newpayload['Check'][] = $ck;
            }
        }
        return $newpayload;
    }

    private function write_statements_transactions_file($client, $filename, $invoices, $checks)
    {

        echo "Writing ".$filename."\n";
        // setup document root 'client'

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $root = $doc->createElement('client');
        $doc->appendChild($root);
        // clientname
        $clientid = $doc->createElement('client_id');
        $root->appendChild($clientid);
        $text = $doc->createTextNode($client['Client']['id']);
        $clientid->appendChild($text);
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $dategenerated->appendChild($text);
        // append invoices list to client

        $this->append_invoices_to_client_root($doc, $root, $invoices);
        // append checks list to client
        $this->append_checks_to_client_root($doc, $root, $checks);

        if($f = fopen($filename,'w'))
        {
            fwrite($f, $doc->saveXML());
            fclose($f);
        } else {
            print "could not open ".$filename;
        }
    }
    private function write_open_transactions_file($client, $filename, $invoices)
    {
        // setup document root 'client'

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $root = $doc->createElement('client');
        $root = $doc->appendChild($root);
        // clientname
        $clientname = $doc->createElement('client_id');
        $clientname = $root->appendChild($clientname);

        $text = $doc->createTextNode($client['Client']['id']);
        $text = $clientname->appendChild($text);
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);

        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);

        $invoicesE = $doc->createElement('invoices');
        $invoicesE = $root->appendChild($invoicesE);
        // create Invoice List
        foreach($invoices as $inv)
        {
            $invoice = $doc->createElement('invoice');
            $text = $doc->createTextNode((string) $inv);
            $text = $invoice->appendChild($text);
            $invoicesE->appendChild($invoice);
        }
        if($f = fopen($filename,'w'))
        {
            fwrite($f, $doc->saveXML());
            fclose($f);
        } else {
            print "could not open ".$filename;
        }
    }

    private function append_invoices_to_client_root($doc, $root, $invoices)
    {
        $invoicesE = $doc->createElement('invoices');
        $invoicesE = $root->appendChild($invoicesE);
        // create Invoice List

        if(!empty($invoices))
        {
            foreach($invoices as $inv)
            {
                $invoice = $doc->createElement('invoice');
                if($inv != Null)
                {
                    $text = $doc->createTextNode((string) $inv);
                } else {

                    $text = $doc->createTextNode((string) 'Null_Invoice');
                }
                $text = $invoice->appendChild($text);
                $invoicesE->appendChild($invoice);
            }
        }
        return $invoicesE;

    }
    private function append_checks_to_client_root($doc, $root, $checks)
    {
        $checksE = $doc->createElement('checks');
        $checksE = $root->appendChild($checksE);
        // create checks list
        foreach($checks as $inv)
        {
            $check = $doc->createElement('check');
            if($inv != Null)
            {
                $text = $doc->createTextNode((string) $inv);
            } else {

                $text = $doc->createTextNode((string) 'Null_Invoice');
            }
            $text = $check->appendChild($text);
            $checksE->appendChild($check);
        }
        return $checksE;
    }
    // record primary keys of all invoices and checks ever created for the clients
    function cache_invoices() {
        /*
         * Writes the client's ar fixtures (statements)
         */

        ini_set('memory_limit', '-1');

        $clients = $this->find('all');
        echo "Caching invoices for clients ...\n";
        foreach ($clients as $client)
        {
            // skip inactives unless never syncd
            $statementdir = $this->xml_home.'clients/statements/';
            $filename = $statementdir.str_pad((string)$client['Client']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            echo ' processing '.$filename;
            echo "\n";
            if($client['Client']['active']==1)
            {
                // get invoice and check transactions from db
                $invoicesdb = array();
                $invoicesdb['Invoice'] = $this->invoices_all($client['Client']['id']);
                $checksdb = array();
                $checksdb['Check'] = $this->checks_all($client['Client']['id']);

                // if statement file does not exist create it, completely
                if(!file_exists ($filename) )
                {
                    echo 'starting file '. $filename;
                    $this->write_statements_transactions_file($client,$filename, $invoicesdb['Invoice'], $checksdb['Check']);
                } else  // statement file exists, update the statement with new transactiosn
                {
                    $payload = $this->statementsComp->generate_statement($client['Client']['id']);
                    $payload = $this->append_new_transactions_to_statement_array($payload,$invoicesdb, $checksdb);
                    $this->write_statements_transactions_file($client,$filename, $payload['Invoice'],$payload['Check']);
                }
            }
            // if client is inactive do a complete rebuild if file does not exist
            if(!$client['Client']['active'] && !file_exists (  $filename ))
            {
                $invoices = array();
                $invoices['Invoice'] = $this->invoices_all($client['Client']['id']);
                $checks = array();
                $checks['Check'] = $this->checks_all($client['Client']['id']);

                $this->write_statements_transactions_file($client, $filename, $invoices, $checks['Check']);
            }
        }
    }
    function cache_client_open_invoices() {
        $clients = $this->find('all');

        echo "Caching Open Invoices invoices ...\n";
        foreach ($clients as $client)
        {
            $invoices = $this->invoices($client['Client']['id']);
            $invList = array();
            foreach($invoices['Invoice'] as $inv)
            {
                $invList[] = $inv['Invoice']['id'];
            }
            $filename = $this->dsComp->client_open_invoices_file($client['Client']['id']);
            echo "Caching Open Invoices for ".$client['Client']['name'].' into '.$filename."\n";
            $this->write_open_transactions_file($client,$filename, $invList);
        }
    }
    function cache_clients() {

        echo "Caching clients into archive...\n";
        ini_set('memory_limit', '-1');

        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $this->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsCheck','ClientsSearch'),),false);
        $clients = $this->find('all');
        $clientsJS  = array();
        $clientsJS['clients']  = array();

        foreach ($clients as $client)
        {
            $clientsJS['clients'][$client['Client']['id']] = array('id'=>$client['Client']['id'],'name'=>$client['Client']['name'],'active'=>$client['Client']['active']);
            $clientssdir = $this->xml_home.'clients/';
            $filename = $clientssdir.str_pad((string)$client['Client']['id'], 5, "0", STR_PAD_LEFT).'.xml';

            if(!file_exists (  $filename ) )
            {
                $this->sync($client,$filename);
            }
            else
            {
                if (strtotime($client['Client']['modified_date']) > strtotime($client['Client']['last_sync_time']))
                {
                    $this->sync($client,$filename);
                }
            }
        }
        /*
         *  Write JSON fixture for the Javascript apps
         */
        $clientsJS['date_generated'] = date('D, d M Y H:i:s');
        $jsonComp = new JsonComponent;
        $f = fopen($this->xml_home.'clients/clients.json','w');
        fwrite($f,$jsonComp->clients_jquery($clientsJS));
        fclose($f);
    }

}
