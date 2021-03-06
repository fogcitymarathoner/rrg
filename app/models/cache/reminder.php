<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 12/4/13
 * Time: 2:14 PM
 * To change this template use File | Settings | File Templates.
 */

App::import('Model', 'Reminder');

class ReminderCache extends Reminder
{

    private function cache_timecards($reminders)
    {
        $timecardsJ = $this->jsonComp->reminders_timecards_opens_voids($reminders['timecards'], 'timecards');
        $this->jsonComp->cache_timecards($timecardsJ);
    }

    private function cache_voids($reminders)
    {
        $voidsJ = $this->jsonComp->reminders_timecards_opens_voids($reminders['voids'], 'voids');
        $this->jsonComp->cache_voids($voidsJ);
    }

    private function cache_opens($reminders)
    {
        $voidsJ = $this->jsonComp->reminders_timecards_opens_voids($reminders['opens'], 'opens');
        $f = fopen($this->xml_home . 'reminders/opens.json', 'w');
        fwrite($f, $voidsJ);
        fclose($f);
    }

    private function cache_sent_timecard_receipts($reminders)
    {
        $sents = $reminders['timecard_receipts_sent'];

        $f = fopen($this->xml_home . 'reminders/sent_timecard_receipts.json', 'w');
        $sents['date_generated'] = date('D, d M Y H:i:s');
        $sents = $this->jsonComp->timecard_receipts($sents);
        fwrite($f, $sents);
        fclose($f);
    }

    private function cache_unsent_timecard_receipts($reminders)
    {
        $unsents = $reminders['timecard_receipts_pending'];


        $f = fopen($this->xml_home . 'reminders/unsent_timecard_receipts.json', 'w');
        $unsents['date_generated'] = date('D, d M Y H:i:s');
        $unsents = $this->jsonComp->timecard_receipts($unsents);
        fwrite($f, $unsents);
        fclose($f);
    }


    /*
     * invoices emailable.  look at all the reminders and mark the ones
     * that meet the emailable criteria
     *
     */
    private function reminders_emailenable($reminders)
    {
        $reminders_inwait = array();
        $reminders_emailenable = array();
        foreach ($reminders['reminders'] as $reminder) {
            /*
             * skip date_generated cell
             */
            if (isset($reminder['Invoice'])) {
                $datearray = date_parse($reminder['Invoice']['date']);
                $date = mktime(0, 0, 0, $datearray['month'], $datearray['day'] + $reminder['Invoice']['terms'], $datearray['year']);
                $datearray = date_parse($reminder['Invoice']['period_end']);
                $enddate = mktime(0, 0, 0, $datearray['month'], $datearray['day'], $datearray['year']);
                $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                if ($today < $enddate) {
                    $emailable = 0;
                    $reminders_inwait[] = $reminder;
                } else {
                    $emailable = 1;

                    $reminders_emailenable[] = $reminder;

                }
                //$reminders_emailenable[] = array('id'=>$reminder['Invoice']['id'],'timecard'=>$reminder['Invoice']['timecard'],'voided'=>$reminder['Invoice']['voided'],'emailenable'=>$emailable);
            }
        }
        return array('reminders_emailable' => $reminders_emailenable, 'reminders_inwait' => $reminders_inwait);
    }

    function cache_emailable_inwait_reminders($reminders)
    {
        $reminders_cleaned = $this->reminders_emailenable($reminders);

        $this->write_reminder_fixtures($reminders_cleaned);
        // write all reminders
        $this->cache_all_reminders($reminders);
    }

    function update_json_reminder($id)
    {
        $fixfile = $this->xml_home . 'reminders/reminders_emailenable.json';
        $fsize = filesize($fixfile);
        if ($fsize) {
            $f = fopen($fixfile, 'r');
            $doc = json_decode(fread($f, $fsize));

            fclose($f);
            $res = array();

            foreach ($doc->reminders as $r) {
                if ($r->id != $id) {
                    $res['reminders'][$r->id] = $r;
                } else {
                    $ret = $this->jsonComp->setupReminder($this->Invoice->read(null, $id));
                    $res['reminders'][$r->id] = $ret;
                }
            }
            // save to file
            $this->jsonComp->cache_emailable_reminders(json_encode($res));
            return json_encode($ret);
        }
    }

    function update_json_timecard($id)
    {
        $fixfile = $this->xml_home . 'reminders/timecards.json';
        $fsize = filesize($fixfile);
        if ($fsize) {
            $f = fopen($fixfile, 'r');
            $doc = json_decode(fread($f, $fsize));

            fclose($f);
            $res = array();

            foreach ($doc->timecards as $r) {
                if ($r->id != $id) {
                    $res['timecards'][$r->id] = $r;
                } else {
                    $ret = $this->jsonComp->setupReminder($this->Invoice->read(null, $id));
                    $res['timecards'][$r->id] = $ret;
                }
            }
            // save to file
            $this->jsonComp->cache_timecards(json_encode($res));
            return json_encode($ret);
        }
    }


    private function write_reminder_fixtures($reminders_cleaned)
    {

        // write down emailable reminders
        $reminders_emailenable['reminders'] = $reminders_cleaned['reminders_emailable'];
        $reminders_emailenable['date_generated'] = date('D, d M Y H:i:s');
        $reminders_emailenable = $this->jsonComp->reminders_timecards_opens_voids($reminders_emailenable['reminders'], 'reminders');
        $this->jsonComp->cache_emailable_reminders($reminders_emailenable);
        // write down inwait reminders
        //
        // ??? Invoices where the last day of period has not passed
        $reminders_emailenable = array();
        $reminders_emailenable['reminders'] = $reminders_cleaned['reminders_inwait'];
        $reminders_emailenable['date_generated'] = date('D, d M Y H:i:s');
        $reminders_emailenable = $this->jsonComp->reminders_timecards_opens_voids($reminders_emailenable['reminders'], 'reminders_inwait');
        $this->jsonComp->cache_inwait_reminders($reminders_emailenable);
    }


    private function cache_all_reminders($reminders)
    {
        $reminderJ = $this->jsonComp->reminders_timecards_opens_voids($reminders['reminders'], 'reminders');
    }


    function reminders()
    {

        $reminders = $this->Invoice->select_reminders();
        return $reminders;
    }

    public function unbindContractModelForCaching()
    {
        $this->Invoice->unbindModel(array('hasMany' => array('InvoicesPayment', 'InvoicesItem', 'EmployeesPayment',),), false);
        $this->Invoice->ClientsContract->unbindModel(array('hasMany' => array('Invoice', 'ContractsItem'),), false);
        $this->Invoice->ClientsContract->unbindModel(array('belongsTo' => array('State', 'Period', 'Employee', 'Client',),), false);
        $this->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager', 'User',),), false);
        $this->Invoice->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),), false);
        $this->Invoice->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),), false);
        $this->Invoice->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),), false);
        $this->Invoice->InvoicesTimecardReminderLog->unbindModel(array('belongsTo' => array('Invoice',),), false);
        $this->Invoice->InvoicesPostLog->unbindModel(array('belongsTo' => array('Invoice',),), false);
        $this->Invoice->InvoicesTimecardReceiptLog->unbindModel(array('belongsTo' => array('Invoice',),), false);
    }

    function create_invoice_for_period($clientsContract, $periodstart, $periodend)
    {

        $client = $this->Client->read(NULL, $clientsContract['Client']['id']);
        if (!$client['Client']['hq']) {
            $invcount = $this->Invoice->find('count', array(
                'conditions' => array('period_start' => $periodstart, 'period_end' => $periodend,
                    'contract_id' => $clientsContract['ClientsContract']['id'], 'mock' => 0)
            ));
            if ($invcount == 0) {
                $token = $this->Tk->generatePassword();
                $invoice = array();
                $invoice['Invoice']['contract_id'] = $clientsContract['ClientsContract']['id'];
                $invoice['Invoice']['date'] = date("Y-m-d");
                $invoice['Invoice']['period_start'] = $periodstart;
                $invoice['Invoice']['period_end'] = $periodend;
                $invoice['Invoice']['terms'] = $clientsContract['ClientsContract']['terms'];
                $invoice['Invoice']['employerexpenserate'] = $clientsContract['ClientsContract']['employerexp'];
                $invoice['Invoice']['created_date'] = date('Y-m-d');
                $invoice['Invoice']['token'] = $token;
                $invoice['Invoice']['view_count'] = 0;
                $invoice['Invoice']['mock'] = 0;
                $invoice['Invoice']['created_date'] = date('Y-m-d h:i:s');
                $user = 5; //marc
                $invoice['Invoice']['modified_user_id'] = $user;
                $invoice['Invoice']['created_user_id'] = $user;
                $employee = $clientsContract['Employee'];
                $this->Invoice->create();
                $this->Invoice->save($invoice);
                $invoiceID = $this->Invoice->getLastInsertID();
                $items = $this->Invoice->ClientsContract->ContractsItem->find('all', array(
                    'conditions' => array('contract_id' => $clientsContract['ClientsContract']['id'],
                        'ContractsItem.active' => 1),
                    'order' => 'ContractsItem.ordering ASC'
                ));
                foreach ($items as $item):
                    if ($item['ContractsItem']['active'] == 1) {
                        $invoicelineitem = array();
                        $invoicelineitem['InvoicesItem']['description'] = $item['ContractsItem']['description'];
                        $invoicelineitem['InvoicesItem']['amount'] = $item['ContractsItem']['amt'];
                        $invoicelineitem['InvoicesItem']['cost'] = $item['ContractsItem']['cost'];
                        $invoicelineitem['InvoicesItem']['ordering'] = $item['ContractsItem']['ordering'];
                        $invoicelineitem['InvoicesItem']['invoice_id'] = $invoiceID;

                        $this->Invoice->InvoicesItem->create();
                        $this->Invoice->InvoicesItem->save($invoicelineitem);
                        foreach ($item['ContractsItemsCommissionsItem'] as $citem):
                            $invlineitemcommslineitem = array();
                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['employee_id'] = $citem['employee_id'];
                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['date'] = $invoice['Invoice']['date'];


                            $datea = array();
                            $datea['month'] = date("m", strtotime($invoice['Invoice']['date']));
                            $datea['year'] = date("Y", strtotime($invoice['Invoice']['date']));


                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['commissions_report_id'] =
                                $this->commsComp->reportID_fromdate($datea);
                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['description'] = $employee['firstname'] . ' ' . $employee['lastname'];
                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['percent'] = $citem['percent'];
                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['invoices_item_id'] =
                                $this->Invoice->InvoicesItem->getLastInsertID();

                            $this->Invoice->InvoicesItem->InvoicesItemsCommissionsItem->create();
                            $this->Invoice->InvoicesItem->InvoicesItemsCommissionsItem->save($invlineitemcommslineitem);
                        endforeach;
                    }
                endforeach;
            }
        }
    }

}