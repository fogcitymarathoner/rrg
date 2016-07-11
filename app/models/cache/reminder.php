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

    function cache_reminders()
    {
        echo "Caching reminders for Ajax app timecards, voids, opens, .....\n";
        /*
         * cache json files reminders, timecards, opens, and voids
         */

        $reminders = $this->reminders();
        echo 'Made query\n';
        echo "caching in wait reminders\n";
        $this->cache_emailable_inwait_reminders($reminders);
        echo "caching timecards \n";
        $this->cache_timecards($reminders);
        echo "caching voids\n";
        $this->cache_voids($reminders);
        echo "caching opens\n";
        $this->cache_opens($reminders);
        echo "caching unsent timecard receipts\n";
        $this->cache_unsent_timecard_receipts($reminders);
        echo "caching sent timecard receipts\n";
        $this->cache_sent_timecard_receipts($reminders);
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

                            $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['commissions_reports_tag_id'] =
                                $this->CommissionsReportsTag->shell_tagID($invlineitemcommslineitem['InvoicesItemsCommissionsItem']['employee_id'], $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['commissions_report_id']);
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

    function generate_reminders()
    {
        echo "Entering generate of reminders cache model\n";
        Configure::write('debug', 1);
        echo '  in generate' . "\n";
        echo '  constructed invoice model' . "\n";
        $this->Invoice->ClientsContract->recursive = 0;
        $sixtyDaysback = mktime(0, 0, 0, date("m"), date("d") - 60, date("Y"));
        // Weekly

        $clientsContracts = $this->Invoice->ClientsContract->find('all', array(
            'fields' => array(
                'ClientsContract.id',
                'ClientsContract.title',
                'ClientsContract.terms',
                'ClientsContract.employerexp',
                'ClientsContract.startdate',
                'Employee.firstname',
                'Employee.lastname',
                'Client.id',
                'Client.name'),
            'conditions' => array('ClientsContract.active' => 1,
                'ClientsContract.period_id' => 1,
                'Employee.active' => 1,
                'Employee.voided' => 0,
                'Client.active' => 1,
                'ClientsContract.startdate >0000-00-00'),
            'order' => array('Employee.firstname ASC', 'Employee.lastname ASC')
        ));

        foreach ($clientsContracts as $clientsContract):

            $startdatearray = explode('-', $clientsContract['ClientsContract']['startdate']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $week = -1;
            $periodstart = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 1 + (7 * $week), $startdatearray[0]);
            $periodend = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 7 + (7 * $week), $startdatearray[0]);
            $today = mktime(0, 0, 0, date("m"), date("d") + 7, date("Y"));
            while ($periodend < $today):
                if ($periodend > $sixtyDaysback) {
                    $this->create_invoice_for_period($clientsContract, date('Y-m-d', $periodstart), date('Y-m-d', $periodend));
                }
                $week++;
                $periodstart = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 1 + (7 * $week), $startdatearray[0]);
                $periodend = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 7 + (7 * $week), $startdatearray[0]);
            endwhile;
        endforeach;
        // Semi Monthly
        $clientsContracts = $this->ClientsContract->find('all', array(
            'fields' => array(
                'ClientsContract.id',
                'ClientsContract.title',
                'ClientsContract.terms',
                'ClientsContract.employerexp',
                'ClientsContract.startdate',
                'Employee.firstname',
                'Employee.lastname',
                'Client.id',
                'Client.name'),
            'conditions' => array('ClientsContract.active' => 1,
                'ClientsContract.period_id' => 2,
                'Employee.active' => 1,
                'Employee.voided' => 0,
                'Client.active' => 1,
                'ClientsContract.startdate >0000-00-00'),
            'order' => array('Employee.firstname ASC', 'Employee.lastname ASC')
        ));
        foreach ($clientsContracts as $clientsContract):
            $startdatearray = explode('-', $clientsContract['ClientsContract']['startdate']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $month = -1;
            $first_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 1, $startdatearray[0]);
            $lastday_of_month = mktime(0, 0, 0, $startdatearray[1] + $month + 1, 1, $startdatearray[0]) - 24 * 60 * 60;
            $firstday_of_next_month = mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"));
            while ($lastday_of_month < $firstday_of_next_month):
                $month++;
                $first_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 1, $startdatearray[0]);
                $fifteenth_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 15, $startdatearray[0]);
                $sixteenth_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 16, $startdatearray[0]);
                $lastday_of_month = mktime(0, 0, 0, $startdatearray[1] + $month + 1, 1, $startdatearray[0]) - 24 * 60 * 60;
                if ($fifteenth_of_month > $sixtyDaysback) {
                    $this->create_invoice_for_period($clientsContract, date('Y-m-d', $first_of_month), date('Y-m-d', $fifteenth_of_month));
                }
                if ($lastday_of_month > $sixtyDaysback) {
                    $this->create_invoice_for_period($clientsContract, date('Y-m-d', $sixteenth_of_month), date('Y-m-d', $lastday_of_month));
                }
            endwhile;
        endforeach;
        // Monthly
        $clientsContracts = $this->ClientsContract->find('all', array(
            'fields' => array(
                'ClientsContract.id',
                'ClientsContract.title',
                'ClientsContract.terms',
                'ClientsContract.employerexp',
                'ClientsContract.startdate',
                'Employee.firstname',
                'Employee.lastname',
                'Client.id',
                'Client.name'),
            'conditions' => array('ClientsContract.active' => 1,
                'ClientsContract.period_id' => 3,
                'Employee.active' => 1,
                'Employee.voided' => 0,
                'Client.active' => 1,
                'ClientsContract.startdate >0000-00-00'),
            'order' => array('Employee.firstname ASC', 'Employee.lastname ASC')
        ));
        foreach ($clientsContracts as $clientsContract):
            $startdatearray = explode('-', $clientsContract['ClientsContract']['startdate']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $month = -1;
            $first_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 1, $startdatearray[0]);
            $lastday_of_month = mktime(0, 0, 0, $startdatearray[1] + $month + 1, 1, $startdatearray[0]) - 24 * 60 * 60;
            $firstday_of_next_month = mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"));
            while ($lastday_of_month < $firstday_of_next_month):
                $month++;
                $first_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 1, $startdatearray[0]);
                $fifteenth_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 15, $startdatearray[0]);
                $sixteenth_of_month = mktime(0, 0, 0, $startdatearray[1] + $month, 16, $startdatearray[0]);
                $lastday_of_month = mktime(0, 0, 0, $startdatearray[1] + $month + 1, 1, $startdatearray[0]) - 24 * 60 * 60;
                if ($lastday_of_month > $sixtyDaysback) {
                    $this->create_invoice_for_period($clientsContract, date('Y-m-d', $first_of_month), date('Y-m-d', $lastday_of_month));
                }
            endwhile;
        endforeach;


        // Biweekly
        $clientsContracts = $this->ClientsContract->find('all', array(
            'fields' => array(
                'ClientsContract.id',
                'ClientsContract.title',
                'ClientsContract.terms',
                'ClientsContract.employerexp',
                'ClientsContract.startdate',
                'Employee.firstname',
                'Employee.lastname',
                'Client.id',
                'Client.name'),
            'conditions' => array('ClientsContract.active' => 1,
                'ClientsContract.period_id' => 5,
                'Employee.active' => 1,
                'Employee.voided' => 0,
                'Client.active' => 1,
                'ClientsContract.startdate >0000-00-00'),
            'order' => array('Employee.firstname ASC', 'Employee.lastname ASC')
        ));

        foreach ($clientsContracts as $clientsContract):

            $startdatearray = explode('-', $clientsContract['ClientsContract']['startdate']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $week = -2;
            $periodstart = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 1 + (14 * $week), $startdatearray[0]);
            $periodend = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 14 + (14 * $week), $startdatearray[0]);
            $today = mktime(0, 0, 0, date("m"), date("d") + 7, date("Y"));
            while ($periodend < $today):
                if ($periodend > $sixtyDaysback) {
                    $this->create_invoice_for_period($clientsContract, date('Y-m-d', $periodstart), date('Y-m-d', $periodend));
                }
                $week++;
                $periodstart = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 1 + (14 * $week), $startdatearray[0]);
                $periodend = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] - date('w', $startdatetime) + 14 + (14 * $week), $startdatearray[0]);
            endwhile;
        endforeach;
    }

}