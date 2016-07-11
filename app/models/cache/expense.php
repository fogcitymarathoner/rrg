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
App::import('Model', 'Expense');

class ExpenseCache extends Expense {

    //

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
        $this->data = $this->read(null, $id);
        $this->ClientsContract->Invoice->recursive = 2;
        $invoices = $this->ClientsContract->Invoice->find('all',
            array('order' =>'date DESC',
                'conditions'=>array('ClientsContract.client_id'=>$id,
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
        App::import('Component', 'DateFunction');
        App::import('Component', 'InvoiceFunction');
        $dateF = new DateFunctionComponent();
        $invF = new InvoiceFunctionComponent();
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
            $open[$count]['Invoice']['dayspast'] = $dateF->dateDiff(date('Y-m-d',$duedate),date('Y-m-d',$today));
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

    private function write_statements_transactions_file($client,$filename, $invoices, $checks)
    {
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'client'
        $root = $doc->createElement('client');
        $root = $doc->appendChild($root);
        // clientname
        $clientid = $doc->createElement('client_id');
        $clientid = $root->appendChild($clientid);
        $text = $doc->createTextNode($client['Client']['id']);
        $text = $clientid->appendChild($text);
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);
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
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'client'
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
    /*
     * Write fixture down mark employee as synced
     */
    private function sync($exp, $fixfilename)
    {

        if($f = fopen($fixfilename,'w'))
        {
            fwrite($f, $this->xmlComp->serialize_expense($exp));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $expsave = array();
        $expsave['Expense'] = $exp['Expense'];

        /* repair dates if there are problems */
        if($exp['Expense']['created_user_id'] == Null)
            $expsave['Expense']['created_user_id'] = 5;
        if($exp['Expense']['modified_user_id'] == Null)
            $expsave['Expense']['modified_user_id'] = 5;
        if($exp['Expense']['created_user_id'] == 0)
            $expsave['Expense']['created_user_id'] = 5;
        if($exp['Expense']['created_user_id'] == 0)
            $expsave['Expense']['modified_user_id'] = 5;

        if($exp['Expense']['modified_date'] == Null)
            $expsave['Expense']['modified_date']= date('Y-m-d H:i:s');
        if($exp['Expense']['modified_date'] == '0000-00-00 00:00:00.000000')
            $expsave['Expense']['modified_date']= date('Y-m-d H:i:s');
        if($exp['Expense']['created_date'] == Null)
            $expsave['Expense']['created_date']= date('Y-m-d');

        if($exp['Expense']['created_date'] == '0000-00-00')
            $expsave['Expense']['created_date']= date('Y-m-d');

        $expsave['Expense']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($expsave);
    }
    function cache_expenses() {

        echo "Caching expenses into archive...\n";

        ini_set('memory_limit', '-1');

        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));

        $expenses = $this->find('all');
        $expensesJS  = array();
        $expensesJS['expenses']  = array();


        foreach ($expenses as $exp)
        {
            $expensesJS['expenses'][$exp['Expense']['id']] = array('id'=>$exp['Expense']['id'],'category'=>$exp['Expense']['category_id'],'employee'=>$exp['Expense']['employee_id']);

            $expensesdir = $this->xml_home.'expenses/';
            $filename = $expensesdir.str_pad((string)$exp['Expense']['id'], 5, "0", STR_PAD_LEFT).'.xml';

            if(!file_exists (  $filename ) )
            {
                $this->sync($exp, $filename);
            }
            else
            {
                if (strtotime($exp['Expense']['modified_date']) > strtotime($exp['Expense']['last_sync_time']))
                {
                    $this->sync($exp, $filename);
                }
            }
        }
    }

}