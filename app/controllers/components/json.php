<?php
/*
 * defines a class TimecardReceipts
 */
App::import('Vendor', 'reminders');

class JsonComponent
{

    //
    public function __construct() {

        $this->xml_home = Configure::read('xml_home');

    }

    function json_vector($idarray)
    {
        $res =  '{';
        if (count($idarray)>1)
        {
            $j=1;
            foreach($idarray as $id):

                $res .=   '"'.$id.'":'.$id;
                if($j++ < count($idarray))
                    $res .=  ',';
            endforeach;
        } else {
            $res .=  '"'.$idarray[0].'":'.$idarray[0];
        }
        $res .=  '}';
        return $res;
    }
    # compares payments against invoice amount to calculate balances
    private function calculateBalances($invoices)
    {
        $count = 0;
        foreach ($invoices as $invoice):
            $balance = $invoices[$count]['Invoice']['amount'];
            foreach ($invoice['InvoicesPayment'] as $pay):
                $balance -= $pay['amount'];
            endforeach;
            $invoices[$count]['Invoice']['balance'] = $balance;
            $count++;
        endforeach;
        return $invoices;
    }

    private function json_invoice($invoice)
    {
        return '{'.
            '"id":'.$invoice['Invoice']['id'].','.
            '"period_start":"'.date('m/d/Y',strtotime($invoice['Invoice']['period_start'])).'",'.
            '"period_end":"'.date('m/d/Y',strtotime($invoice['Invoice']['period_end'])).'",'.
            '"date":"'.date('m/d/Y',strtotime($invoice['Invoice']['date'])).'",'.
            '"terms":'.$invoice['Invoice']['terms'].','.
            '"amount":'.$invoice['Invoice']['amount'].','.
            '"con_id":'.$invoice['Invoice']['contract_id'].','.
            '"notes":"'.$invoice['Invoice']['notes'].'",'.
            '"employee_id":'.$invoice['ClientsContract']['employee_id'].','.
            '"client_id":'.$invoice['ClientsContract']['client_id'].
            '}';
    }
    function json_open_invoices($client_id)
    {
        $invM = new Invoice;

        $invM->recursive = 1;
        $invM->unbindModel(array('hasMany' => array('InvoicesItem',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
//debug($client_id);
        $invoices = $invM->find('all', array(
                'conditions'=>array('voided'=>0,'posted'=>1,'cleared'=>0,
                    'ClientsContract.client_id' => $client_id,
                ),
                'fields'=>array(
                    'Invoice.id',
                    'Invoice.period_start',
                    'Invoice.period_end',
                    'Invoice.date',
                    'Invoice.terms',
                    'Invoice.amount',
                    'Invoice.contract_id',
                    'Invoice.notes',
                    'ClientsContract.employee_id',
                    'ClientsContract.client_id',
                ),
                'order'=>array('Invoice.id ASC'),
            )
        );

//$log = $invM->getDataSource()->getLog(false, false);
//debug($log);
//debug($invoices);exit;
        $invoices = $this->calculateBalances($invoices);
        $j=1;
        $invcount = count($invoices);
        $res = '[';
        foreach($invoices as $i):
            if($i['Invoice']['id'])
            {
                    $res .= $this->json_invoice($i);
                if($j < $invcount)
                    $res .= ',';
            }
            $j++;
        endforeach;
        $res .= ']';
        return array('json'=>$res, 'invoices'=> $invoices);
    }
    function json_invoices_frontend($invoices)
    {
        $j=0;
        $invcount = count($invoices);
        $res = '{"invoices": {';
        foreach($invoices as $inv):
            $res .= '"'.$inv['Invoice']['id'].'":';
            $res .= '{'.
            '"e_id":'.$inv['ClientsContract']['employee_id'].','.
            '"c_id":'.$inv['ClientsContract']['client_id'].
            '}';
            if($j < $invcount-1)
                $res .= ',';
            $j++;
            if($inv['Invoice']['id'])
            {
            }
        endforeach;
        $res .= '}}';
        return $res;
    }
    function json_label_fixture($fixobj)
    {
        $res =  '{';
        if (count($fixobj['Employee'])>0)
        {
            $res .= '"row":"'.$fixobj['row'].'",';
            $res .= '"column":"'.$fixobj['column'].'",';
            $res .= '"mode":"'.$fixobj['mode'].'",';
            $res .= '"user_email":"'.$fixobj['user_email'].'",';
            $res .= '"fixture-random":"'.$fixobj['fixture-random'].'",';
            $res .= '"employees":[';
            $j=1;
            foreach($fixobj['Employee'] as $id):
                $res .=   '{"id":"'.$id.'"}';
                if($j++ < count($fixobj['Employee']))
                    $res .=  ',';
            endforeach;
            $res .= ']';
        } else {
            $res .=  '"id":'.$fixobj['Employee'][0];
        }
        $res .=  '}';
        return $res;
    }
    function soap_json_label_fixture($fixobj)
    {
        $res =  '{';
        if (count($fixobj['employees'])>0)
        {
            $res .= '"row":"'.$fixobj['row'].'",';
            $res .= '"column":"'.$fixobj['column'].'",';
            if(isset($fixobj['mode'])){
                $res .= '"mode":"'.$fixobj['mode'].'",';
            }
            $res .= '"user_email":"'.$fixobj['user_email'].'",';
            $res .= '"fixture-random":"'.$fixobj['fixture-random'].'",';
            $res .= '"employees":[';
            $j=1;
            foreach($fixobj['employees'] as $id):
                $res .=   '{"id":"'.$id['id'].'"}';
                if($j++ < count($fixobj['employees']))
                    $res .=  ',';
            endforeach;
            $res .= ']';
        } else {
            $res .=  '"id":'.$fixobj['employees'][0];
        }
        $res .=  '}';
        return $res;
    }
    function employees_json($employees)
    {
        $res = '{"Employee": {';
        $i =0;
        foreach($employees as $emp)
        {
            $res .= '"'.$emp['Employee']['id'].'":';
            $res .= '{"first":"'.$emp['Employee']['firstname'];
            $res .= '",';
            $res .= '"last":"'.$emp['Employee']['lastname'];
            $res .= '",';
            $res .= '"dob":"'.$emp['Employee']['dob'];
            $res .= '",';
            $res .= '"startdate":"'.$emp['Employee']['startdate'];
            $res .= '",';
            $res .= '"street1":"'.$emp['Employee']['street1'];
            $res .= '",';
            $res .= '"city":"'.$emp['Employee']['city'];
            $res .= '",';
            $res .= '"zip":"'.$emp['Employee']['zip'];
            $res .= '",';
            $res .= '"usworkstatus":"'.$emp['Employee']['usworkstatus'];
            $res .= '",';
            $res .= '"tcard":"'.$emp['Employee']['tcard'];
            $res .= '",';
            $res .= '"w4":"'.$emp['Employee']['w4'];
            $res .= '",';
            $res .= '"de34":"'.$emp['Employee']['de34'];
            $res .= '",';
            $res .= '"i9":"'.$emp['Employee']['i9'];
            $res .= '",';
            $res .= '"medical":"'.$emp['Employee']['medical'];
            $res .= '",';
            $res .= '"indust":"'.$emp['Employee']['indust'];
            $res .= '",';
            $res .= '"info":"'.$emp['Employee']['info'];
            $res .= '"}';
            if ($i < count($employees)-1)
            {
                $res .= ',';
            }
            $i++;
        }
        $res .= '}}';
        return $res;
    }
    function employees_jquery($employeesJS)
    {
        $res = '{"employees": {';
        $i =0;
        $employee_count = count($employeesJS['employees'] );
        foreach($employeesJS['employees'] as $emp)
        {
            $res .= '"'.$emp['id'].'":{';
            $res .= '"f":"'.$emp['first'].'",';
            $res .= '"l":"'.$emp['last'].'",';
            $res .= '"a":"'.$emp['active'].'",';
            $res .= '"ems":{';
            $j = 0;
            foreach($emp['emails'] as $empem)
            {
                $res .= '"'.$j.'": "'.trim($empem).'"';
                if ($j < count($emp['emails'])-1)
                {
                    $res .= ',';
                }
                $j++;
            }
            $res .= '}}';
            if ($i < $employee_count -1)
            {
                $res .= ',';
            }
            $i++;
        }
        $res .= '}, "date_generated": "'.$employeesJS['date_generated'].'"';
        $res .= '}';
        return $res;
    }
    function contracts_jquery($contracts)
    {
        $res = '{"contracts": {';
        $i =0;
        $contract_count = count($contracts );
        foreach($contracts as $con)
        {
            if(isset($con['ClientsContract']['id']))
            {
                $res .= '"'.$con['ClientsContract']['id'].'":{';
                $res .= '"e_id":"'.$con['ClientsContract']['employee_id'].'",';
                $res .= '"c_id":"'.$con['ClientsContract']['client_id'].'",';
                $res .= '"mmd":';
                $res .= '[ ';
                $j = 0;
                $usercount = count($con['ClientsManager']);
                if($usercount)
                {
                    foreach($con['ClientsManager'] as $user)
                    {
                        $res .= '"'.$user['email'].'"';
                        if ($j++ < $usercount-1)
                            $res .= ',';
                    }
                }
                //$res .= 'e1@asdf.com", "e22@sdaf.com"'
                $res .= '],';
                $res .= '"emd":';
                $res .= '[ ';
                $j = 0;
                $usercount = count($con['User']);
                if($usercount)
                {
                    foreach($con['User'] as $user)
                    {
                        $res .= '"'.$user['email'].'"';
                        if ($j++ < $usercount-1)
                            $res .= ',';
                    }
                }
                //$res .= 'e1@asdf.com", "e22@sdaf.com"'
                $res .= ']';
                $res .= '}';
            }
            if ($i < $contract_count -2) // subtract one for date generated
            {
                $res .= ',';
            }
            $i++;
        }
        $res .= ', "date_generated": "'.$contracts['date_generated'].'"}';
        $res .= '}';
        return $res;
    }
    function clients_jquery($clientsJS)
    {
        $i = 0;
        foreach($clientsJS['clients'] as $cl)
        {
            $clientsJS['clients'][$cl['id']] = array(
                'n'=>$cl['name'],
                'a'=>$cl['active'],
            );
        }
        $clientsJS['date_generated'] = $clientsJS['date_generated'];

        return json_encode($clientsJS);
    }
    function reminders_emailenable($reminders_emailenable)
    {
        $res = '{"reminders_emailenable": {';
        $i =0;
        $reminders_emailenable_size = count($reminders_emailenable);
        foreach($reminders_emailenable as $inv)
        {
            if(isset($inv['id']))
            {
                $res .= '"'.$inv['id'].'":';
                $res .= '{"e":"'.$inv['emailenable'];
                $res .= '",';
                $res .= '"t":"'.$inv['timecard'];
                $res .= '",';
                $res .= '"v":"'.$inv['voided'];
                $res .= '"}';
                /*
                 * skip date generated field
                 */
                if ($i < $reminders_emailenable_size-2)
                {
                    $res .= ',';
                }
                $i++;
            }
        }
        $res .= '}, "date_generated": "'.$reminders_emailenable['date_generated'].'"';
        $res .= '}';
        return $res;
    }
    function cache_reminders($reminders)
    {

        $f = fopen($this->xml_home.'reminders/reminders.json','w');
        fwrite($f,$reminders);
        fclose($f);
    }
    function cache_emailable_reminders($reminders)
    {
        $fixfile = $this->xml_home.'reminders/reminders_emailenable.json';
        $f = fopen($fixfile,'w');
        fwrite($f,$reminders);
        fclose($f);
    }
    function cache_timecards($timecardsJ)
    {

        $f = fopen($this->xml_home.'reminders/timecards.json','w');
        fwrite($f,$timecardsJ);
        fclose($f);
    }
    function cache_inwait_reminders($reminders)
    {

        $f = fopen($this->xml_home.'reminders/reminders_inwait.json','w');
        fwrite($f,$reminders);
        fclose($f);
    }
    function cache_voids($voidsJ)
    {

        $f = fopen($this->xml_home.'reminders/voids.json','w');
        fwrite($f,$voidsJ);
        fclose($f);
    }
    function cache_opens($opensJ)
    {

        $f = fopen($this->xml_home.'reminders/opens.json','w');
        fwrite($f,$opensJ);
        fclose($f);
    }
    private function cache_sent_timecard_receipts($sents)
    {
        $f = fopen($this->xml_home.'reminders/sent_timecard_receipts.json','w');

        fwrite($f,$sents);
        fclose($f);
    }

    function cache_unsent_timecard_receipts($unsents)
    {
        $f = fopen($this->xml_home.'reminders/unsent_timecard_receipts.json','w');


        fwrite($f,$unsents);
        fclose($f);
    }
    private function reminder_log($reminder_log)
    {
        $outarray = new stdClass();
        foreach($reminder_log as $log)
        {
            $outarray->$log['id'] = new stdClass();
            $outarray->$log['id']->em = $log['email'];
            $outarray->$log['id']->ts = $log['timestamp'];
        }

        return($outarray);
    }
    function invoice_item_list($list)
    {
        $outarray = new stdClass();
        foreach($list as $item)
        {
            $outarray->$item['id'] = new stdClass();
            $outarray->$item['id']->id = $item['id'];
            $outarray->$item['id']->d = $item['description'];
            $outarray->$item['id']->a = $item['amount'];
            $outarray->$item['id']->q = $item['quantity'];
        }
        return($this->json_encode($outarray));
    }
    function setupReminder($reminder)
    {
        /*
         * Setup single reminder record for json serialization
         */
        $out = Array();
        $out['id'] = $reminder['Invoice']['id'];
        $out['amt'] = $reminder['Invoice']['amount'];
        $out['ps'] = date('m/d/Y',strtotime ($reminder['Invoice']['period_start']));
        $out['pe'] = date('m/d/Y',strtotime ($reminder['Invoice']['period_end']));
        $out['con_id']=$reminder['Invoice']['contract_id'];
        $out['c_id']=$reminder['ClientsContract']['client_id'];
        $out['e_id']=$reminder['ClientsContract']['employee_id'];
        $out['n']=$reminder['Invoice']['notes'];
        $out['r_log']=$this->reminder_log($reminder['InvoicesTimecardReminderLog']);
        $out['p_log']=$this->reminder_log($reminder['InvoicesPostLog']);
        return $out;
    }
    function reminders_timecards_opens_voids($reminders, $type)
    {
        $outarray  = new stdClass();
        $outarray->$type  = new stdClass();
        foreach($reminders as $reminder)
        {
            if(isset($reminder['Invoice'])  )
            {
                $outarray->$type->$reminder['Invoice']['id'] = $this->setupReminder($reminder);
            }
        }
        $res = $this->json_encode($outarray);
        return ($res);
    }
    function timecard_receipts($receipts)
    {
        $outarray  = new stdClass();
        $outarray->timecard_receipts  = new stdClass();

        foreach($receipts as $rec)
        {
            if(isset($rec['Invoice']) && isset($rec['Invoice']['period_start']))
            {
                $timecard_receipts = new TimecardReceipts();
                $timecard_receipts->id = $rec['Invoice']['id'];

                $id = $rec['Invoice']['id'];
                $timecard_receipts->ps = date('m/d/Y',strtotime ($rec['Invoice']['period_start']));
                $timecard_receipts->pe = date('m/d/Y',strtotime ($rec['Invoice']['period_end']));
                $timecard_receipts->con_id = $rec['Invoice']['contract_id'];
                $timecard_receipts->c_id = $rec['ClientsContract']['client_id'];
                $timecard_receipts->e_id = $rec['ClientsContract']['employee_id'];
                $timecard_receipts->n = $rec['Invoice']['notes'];
                $timecard_receipts->log = $this->reminder_log($rec['InvoicesTimecardReceiptLog']);
                $outarray->timecard_receipts->$id = $timecard_receipts;
            }
        }

        $res = $this->json_encode($outarray);
        return ($res);
    }
    function labelFixtureFullyQualifiedFilename($fixobj)
    {
        $xml_home = Configure::read('xml_home');
        $labelsdir = $xml_home.'labels/fixtures';
        $filename = $labelsdir.DS.$fixobj['fixture-random'];
        return $filename;
    }

    function employees_cached()
    {

        $empfixfile = $this->xml_home.'employees/employees.json';
        $fsize = filesize($empfixfile);
        $f = fopen($empfixfile,'r');
        $doc = fread($f,$fsize);
        fclose($f);
        return $doc;
    }
    function contracts_cached()
    {

        $empfixfile = $this->xml_home.'contracts/contracts.json';
        $fsize = filesize($empfixfile);
        $f = fopen($empfixfile,'r');
        $doc = fread($f,$fsize);
        fclose($f);
        return $doc;
    }

    function timecard_receipts_pending_cached()
    {

        $empfixfile = $this->xml_home.'reminders/unsent_timecard_receipts.json';
        $fsize = filesize($empfixfile);
        $f = fopen($empfixfile,'r');
        $doc = fread($f,$fsize);
        fclose($f);
        return $doc;
    }

    function timecard_receipts_sent_cached()
    {

        $empfixfile = $this->xml_home.'reminders/sent_timecard_receipts.json';
        $fsize = filesize($empfixfile);
        $f = fopen($empfixfile,'r');
        $doc = fread($f,$fsize);
        fclose($f);
        return $doc;
    }

    function clients_cached()
    {

        $clientfixfile = $this->xml_home.'clients/clients.json';
        $fsize = filesize($clientfixfile);
        if ($fsize > 0)
        {
            $f = fopen($clientfixfile,'r');
            $clients_doc = fread($f,$fsize);
            fclose($f);
        } else {
            return '{"reminders": {}, "date_generated": "'.date('D, d M Y H:i:s').'"}';
        }
        return $clients_doc;
    }
    function reminders_cached()
    {
        $reminderfixfile = $this->xml_home.'reminders/reminders_emailenable.json';
        $fsize = filesize($reminderfixfile);
        $f = fopen($reminderfixfile,'r');
        $reminders_doc = fread($f,$fsize);
        fclose($f);
        return $reminders_doc;
    }
    function reminders_waiting_cached()
    {
        $reminderfixfile = $this->xml_home.'reminders/reminders_inwait.json';
        $fsize = filesize($reminderfixfile);
        $f = fopen($reminderfixfile,'r');
        $reminders_doc = fread($f,$fsize);
        fclose($f);
        return $reminders_doc;
    }
    function timecards_cached()
    {
        $timecardsfixfile = $this->xml_home.'reminders/timecards.json';
        $fsize = filesize($timecardsfixfile);
        $f = fopen($timecardsfixfile,'r');
        $timecards_doc = fread($f,$fsize);
        fclose($f);
        return $timecards_doc;
    }

    function opens_cached()
    {
        $openfixfile = $this->xml_home.'reminders/opens.json';
        $fsize = filesize($openfixfile);
        $f = fopen($openfixfile,'r');
        $opens_doc = fread($f,$fsize);
        fclose($f);
        return $opens_doc;
    }
    function voids_cached()
    {
        $voidfixfile = $this->xml_home.'reminders/voids.json';
        $fsize = filesize($voidfixfile);
        $f = fopen($voidfixfile,'r');
        $voids_doc = fread($f,$fsize);
        fclose($f);
        return $voids_doc;
    }
    function sent_timecard_receipts()
    {
        $voidfixfile = $this->xml_home.'reminders/sent_timecard_receipts.json';
        $fsize = filesize($voidfixfile);
        $f = fopen($voidfixfile,'r');
        $voids_doc = fread($f,$fsize);
        fclose($f);
        return $voids_doc;
    }
    function unsent_timecard_receipts()
    {
        $voidfixfile = $this->xml_home.'reminders/unsent_timecard_receipts.json';
        $fsize = filesize($voidfixfile);
        $f = fopen($voidfixfile,'r');
        $voids_doc = fread($f,$fsize);
        fclose($f);
        return $voids_doc;
    }
    function ajax_settings($webroot)
    {
        $res = '{"webroot":"'.$webroot.'",';
        $res .= '"urls":{';
        $res .= '"employeedeactiveurl":"'.$webroot.'soap/employees/activeinactive",';
        $res .= '"employeetimecardurl":"'.$webroot.'soap/employees/timecard",';
        $res .= '"employeemedicalurl":"'.$webroot.'soap/employees/medical",';
        $res .= '"employeew4url":"'.$webroot.'soap/employees/w4",';
        $res .= '"employeeinfourl":"'.$webroot.'soap/employees/info",';
        $res .= '"employeede34url":"'.$webroot.'soap/employees/de34",';
        $res .= '"employeei9url":"'.$webroot.'soap/employees/i9",';
        $res .= '"employeeindusturl":"'.$webroot.'soap/employees/indust",';
        $res .= '"employeevoidurl":"'.$webroot.'soap/employees/voided",';
        $res .= '"employeelabelspdfsendurl":"'.$webroot.'soap/employees/labels_pdf",';
        $res .= '"payroll_labels_pdf_sendurl":"'.$webroot.'soap/employees/payrolls_labels_pdf",';
        $res .= '"employeelabelspdfsendemailurl":"'.$webroot.'soap/employees/labels_pdf_email",';
        $res .= '"soap_employees_labels_pdf":"'.$webroot.'soap/employees/labels_pdf",';
        $res .= '"soap_employees_labels_pdf_email":"'.$webroot.'soap/employees/employees_labels_pdf_email",';
        $res .= '"employeelabelspdfurl":"'.$webroot.'employees/labels_pdf",';
        $res .= '"rebuild_scripts_url":"'.$webroot.'employees_payments/reorder_payments",';
        $res .= '"soap_invoices_timecard_received_url":"'.$webroot.'soap/inv/timecard_received",';

        $res .= '"soap_invoices_set_reminder_void_url":"'.$webroot.'soap/inv/set_reminder_void",';
        $res .= '"soap_invoices_set_timecard_void_url":"'.$webroot.'soap/inv/set_timecard_void",';
        $res .= '"soap_invoices_set_open_void_url":"'.$webroot.'soap/inv/set_open_void",';

        $res .= '"soap_invoices_set_reminders_waiting_void_url":"'.$webroot.'soap/inv/set_reminders_waiting_void",';

        $res .= '"soap_invoices_set_open_void_url":"'.$webroot.'soap/inv/set_open_void",';

        $res .= '"soap_void_push_to_reminders":"'.$webroot.'soap/inv/void_push_to_reminders",';
        $res .= '"soap_reminders_soap_email_url":"'.$webroot.'soap/reminders_ajax/email",';
        $res .= '"soap_invoices_edit_notes_url":"'.$webroot.'soap/inv/edit_notes",';
        $res .= '"soap_invoice_item_list_url":"'.$webroot.'soap/inv/invoice_item_list",';
        $res .= '"soap_reminderlist_url":"'.$webroot.'soap/reminders_ajax/reminderlist",';
        $res .= '"soap_timecardlist_url":"'.$webroot.'soap/reminders_ajax/timecardlist",';
        $res .= '"soap_invoices_save_invoice_url":"'.$webroot.'soap/inv/save_invoice",';
        $res .= '"soap_invoices_edit_invoice_url":"'.$webroot.'soap/inv/edit_invoice",';

        $res .= '"soap_invoices_reminders_waiting_url":"'.$webroot.'soap/inv/reminders_waiting",';
        $res .= '"soap_invoices_open_invoices_url":"'.$webroot.'soap/inv/open_invoices",';
        $res .= '"soap_timecards_receipts_pending_url":"'.$webroot.'soap/inv/timecards_receipts_pending",';
        $res .= '"soap_timecards_receipts_send_url":"'.$webroot.'soap/inv/timecards_receipts_sent",';
        $res .= '"soap_invoices_voided_invoices_url":"'.$webroot.'soap/inv/voided_invoices",';
        /*
         *
         */
        $res .= '"soap_invoices_post_invoice_url":"'.$webroot.'soap/inv/post_invoice",';
        $res .= '"soap_invoices_send_timecard_receipt_url":"'.$webroot.'soap/inv/send_timecard_receipt",';
        $res .= '"invoice_pdf_preview_url":"'.$webroot.'reminders/previewpdf/"';
        $res .= '}';
        $res .= '}';
        return $res;
    }
    function move_reminder_to_void($id)
    {
        $reminders = json_decode($this->reminders_cached());
        $voids = json_decode($this->voids_cached());
        $reminders_tmp  = new stdClass();
        $reminders_tmp->reminders = new stdClass();
        foreach($reminders->reminders as $reminder)
        {
            $rid = $reminder->id;
            if ($rid != $id)
            {
                $reminders_tmp->reminders->$rid = $reminder;
            } else {
                $voids->voids->$rid = $reminders->reminders->$rid;
            }
        }
        $this->cache_voids($this->json_encode($voids));
        $this->cache_emailable_reminders($this->json_encode($reminders_tmp));
    }
    function move_timecard_to_void($id)
    {
        $reminders = json_decode($this->timecards_cached());
        $voids = json_decode($this->voids_cached());
        $reminders_tmp  = new stdClass();
        $reminders_tmp->reminders = new stdClass();
        foreach($reminders->timecards as $reminder)
        {
            $rid = $reminder->id;
            if ($rid != $id)
            {
                $reminders_tmp->timecards->$rid = $reminder;
            } else {
                $voids->voids->$rid = $reminders->timecards->$rid;
            }
        }
        $this->cache_voids($this->json_encode($voids));
        $this->cache_timecards($this->json_encode($reminders_tmp));
    }
    function move_open_to_void($id)
    {
        $reminders = json_decode($this->opens_cached());
        $voids = json_decode($this->voids_cached());
        $reminders_tmp  = new stdClass();
        $reminders_tmp->reminders = new stdClass();
        foreach($reminders->opens as $reminder)
        {
            $rid = $reminder->id;
            if ($rid != $id)
            {
                $reminders_tmp->opens->$rid = $reminder;
            } else {
                $voids->voids->$id = $reminders->opens->$id;
            }
        }
        $this->cache_voids($this->json_encode($voids));
        $this->cache_opens($this->json_encode($reminders_tmp));
    }
    function move_timecard_to_open($id)
    {
        $reminders = json_decode($this->timecards_cached());
        $opens = json_decode($this->opens_cached());
        $reminders_tmp  = new stdClass();
        $reminders_tmp->reminders = new stdClass();
        if(isset($reminders->timecards))
        {

            foreach($reminders->timecards as $reminder)
            {
                $rid = $reminder->id;
                if ($rid != $id)
                {
                    $reminders_tmp->timecards->$rid = $reminder;
                } else {
                    $opens->opens->$rid = $reminders->timecards->$rid;
                }
            }
        }
        $this->cache_opens($this->json_encode($opens));
        $this->cache_timecards($this->json_encode($reminders_tmp));
    }
    function move_reminders_waiting_to_void($id)
    {
        $reminders = json_decode($this->timecards_cached());
        $voids = json_decode($this->voids_cached());
        $reminders_tmp  = new stdClass();
        $reminders_tmp->reminders = new stdClass();
        foreach($reminders->reminders as $reminder)
        {
            $rid = $reminder->id;
            if ($rid != $id)
            {
                $reminders_tmp->reminders->$rid = $reminder;
            } else {
                $voids->voids->$rid = $reminders->reminders->$rid;
            }
        }
        $this->cache_voids($this->json_encode($voids));
        $this->cache_emailable_reminders($this->json_encode($reminders_tmp));
    }
    function move_reminder_to_timecards($id)
    {
        $reminders = json_decode($this->reminders_cached());
        $timecards = json_decode($this->timecards_cached());
        $reminders_tmp  = new stdClass();
        $reminders_tmp->reminders = new stdClass();
        foreach($reminders->reminders as $reminder)
        {
            $rid = $reminder->id;
            if ($rid != $id)
            {
                $reminders_tmp->reminders->$rid = $reminder;
            } else {
                $timecards->timecards->$rid = $reminders->reminders->$rid;
            }
        }
        $this->cache_timecards($this->json_encode($timecards));
        $this->cache_emailable_reminders($this->json_encode($reminders_tmp));
    }
    function move_void_to_reminders($id)
    {
        $reminders = json_decode($this->reminders_cached());
        $voids = json_decode($this->voids_cached());
        $voids_tmp  = new stdClass();
        $voids_tmp->voids = new stdClass();
        foreach($voids->voids as $reminder)
        {
            $rid = $reminder->id;
            if ($rid != $id)
            {
                $voids_tmp->voids->$rid = $reminder;
            } else {
                $reminders->reminders->$rid = $voids->voids->$rid;
            }
        }
        $this->cache_emailable_reminders($this->json_encode($reminders));
        $this->cache_voids($this->json_encode($voids_tmp));
    }

    public function move_pending_receipt_to_sent_receipt($id)
    {
        $sents = json_decode($this->timecard_receipts_sent_cached());
        $pendings = json_decode($this->timecard_receipts_pending_cached());
        $pendings_tmp  = new stdClass();
        $pendings_tmp->timecard_receipts =  new stdClass();

        foreach($pendings->timecard_receipts as $pend)
        {
            $rid = $pend->id;
            if ($rid != $id)
            {
                $pendings_tmp->timecard_receipts->$rid = $pend;
            } else {
                $sents->timecard_receipts->$rid = $pend;
            }
        }

        $sents->date_generated = date('D, d M Y H:i:s');
        $pendings_tmp->date_generated = date('D, d M Y H:i:s');

        $this->cache_sent_timecard_receipts($this->json_encode($sents));
        $this->cache_unsent_timecard_receipts($this->json_encode($pendings_tmp));
    }

    public function json_encode($data)
    {
    /*
     * uses the ident function to pretty print json if version is less than 5.4
     */
        $cur_ver = phpversion();
        $cur_verA = preg_split('/./', $cur_ver);
        if ($cur_verA[1] >3 )
        {
            /*
             * greater than 5.3 user built in pretty print
             */
            return json_encode($data, JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES);
        } else {
            return $this->indent(json_encode($data));
        }
    }
    /**
     * Indents a flat JSON string to make it more human-readable.
     *
     * @param string $json The original JSON string to process.
     *
     * @return string Indented version of the original JSON string.
     */
    private function indent($json) {

        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i=0; $i<=$strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }
}
?>
