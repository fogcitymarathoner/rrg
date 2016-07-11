<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 5/30/2015
 * Time: 3:28 PM
 */

App::import('Model', 'Invoice');

class RemindersComponent extends Object
{

    public function __construct()
    {
        $this->Invoice = new Invoice;
        parent::__construct();
    }

    public function reminders()
    {
        /* remove later when ajax is in effect
         * FIXME: this can be removed after reminders ajax app is IN
         */


        $this->Invoice->recursive = 2;
        $this->Invoice->unbindContractModelForInvoicing();
        $this->Invoice->unbindModel(array('hasMany' => array('InvoicesItem',
            'InvoicesPayment',
            'EmployeesPayment',
        ),), false);

        $this->Invoice->ClientsContract->Client->unbindModel(array('hasMany' => array(
            'ClientsManager',
        ),), false);

        $this->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array(
            'ClientsManager',
        ),), false);
        $this->Invoice->ClientsContract->bindModel(array('belongsTo' => array(
            'Employee', 'Client'
        ),), false);
        $reminders = $this->Invoice->find('all', array(
                'conditions' => array('voided' => 0, 'timecard' => 0, 'cleared' => 0, 'contract_id  >0'),
                'fields' => array(
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
                'order' => array('Invoice.period_start ASC '),
            )
        );
        $count = 0;
        foreach ($reminders as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $date = mktime(0, 0, 0, date('m', strtotime($datearray['month'])), $datearray['mday'] + $invoice['Invoice']['terms'], $datearray['year']);
            $datearray = getdate(strtotime($invoice['Invoice']['period_end']));
            $enddate = mktime(0, 0, 0, date('m', strtotime($datearray['month'])), $datearray['mday'], $datearray['year']);
            $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            if ($today < $enddate) { //debug($startdate);debug($today);exit;
                $reminders[$count]['Invoice']['emailenable'] = 0;
            } else {
                $reminders[$count]['Invoice']['emailenable'] = 1;
            }
            $reminders[$count]['EmployeeEmail'] = $this->Invoice->ClientsContract->Employee->EmployeesEmail->find('all', array('conditions' => array('employee_id' => $reminders[$count]['ClientsContract']['employee_id'])));
            $reminders[$count]['InvoicesTimecardReminderLog'] = $this->Invoice->InvoicesTimecardReminderLog->find('all', array('conditions' => array('InvoicesTimecardReminderLog.invoice_id' => $reminders[$count]['Invoice']['id'])));
            $count++;
        endforeach;
        Return ($reminders);
    }

    public function get_timecards()
    {


        Configure::write('debug', 0);

        $this->Invoice->recursive = 2;


        App::import('Component', 'DateFunction');
        $dateF = new DateFunctionComponent();




        $timecards = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,'timecard'=>1,'posted'=>0,'cleared'=>0,'contract_id  >0'),
                'fields'=>array(
                    'Invoice.id',
                    'Invoice.contract_id',
                    'Invoice.period_start',
                    'Invoice.period_end',
                    'Invoice.date',
                    'Invoice.terms',
                    'Invoice.notes',
                    'Invoice.amount',
                    'Invoice.contract_id',
                    'Invoice.voided',
                    'ClientsContract.employee_id'),
                'order'=>array('Invoice.period_start ASC '),
            )
        );



        $count = 0;
        foreach ($timecards as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
            $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));

            $tmpContr = $this->Invoice->find('all', array('conditions'=>array('Invoice.id'=>$timecards[$count]['Invoice']['id'])));


            $timecards[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
            $timecards[$count]['Invoice']['dayspast'] = $dateF->dateDiff(date('Y-m-d',$duedate),date('Y-m-d',$today));
            $timecards[$count]['Invoice']['filename'] = 'rocketsredglare_invoice_'.$invoice['Invoice']['id'].'_'.
                $invoice['ClientsContract']['Employee']['firstname'].'_'.
                $invoice['ClientsContract']['Employee']['lastname'].'_'.
                $invoice['Invoice']['period_start'].'_to_'.$invoice['Invoice']['period_end'];
            if ($duedate < mktime(0, 0, 0, date("m")  , date("d"), date("Y")))
            {
                $timecards[$count]['Invoice']['pastdue'] = 1;
            } else
            {
                $timecards[$count]['Invoice']['pastdue'] = 0;
            }
            if ($timecards[$count]['Invoice']['amount'] == 0 )
            {
                $timecards[$count]['Invoice']['postenable'] = 0;
            }
            else
            {
                /* staff users */
                if(count($invoice['ClientsContract']['User']))
                {
                    $timecards[$count]['Invoice']['postenable'] = 1;
                } else
                {
                    $timecards[$count]['Invoice']['postenable'] = 0;
                }
            }

            $count++;
        endforeach;
        return ($timecards);
    }



}