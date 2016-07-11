<?php

App::import('Component', 'InvoiceFunction');

App::import('Component', 'Json');
App::import('Component', 'Employee');
App::import('Component', 'Commissions');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'Xml');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'TimecardReceipt');


App::import('Model', 'cache/invoice');
App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsReportsTag');
App::import('Model', 'CommissionsPayment');
App::import('Model', 'Note');
App::import('Model', 'NotesPayment');

App::import('Component', 'InvoicePost');

class InvController extends AppController {
    var $name = 'Inv';
    var $uses = array('Invoice','Reminder');
    var $page_title ;
    var $paginate = array(
        'limit' => 20,
        'contain' => array('Invoice'),
        'order'=>array('date' => 'desc'),
    );

    //
    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->empModel = new Employee;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->jsonComp = new JsonComponent;
        $this->dsComp = new DatasourcesComponent;

        $this->invPostCom = new InvoicePostComponent;
        $this->timecardRecieptComp = new TimecardReceiptComponent;
        $this->xml_home = Configure::read('xml_home');

        $this->commItemModel = new InvoicesItemsCommissionsItem;
        $this->invoiceFunction = new InvoiceFunctionComponent;
        $this->commPayModel = new CommissionsPayment;
        $this->noteModel = new Note;
        $this->notesPaymentModel = new NotesPayment;
        $this->commRptTagModel = new CommissionsReportsTag;
        parent::__construct();
    }
    /* called from radio buttons in reminders index */
    function soap_void_push_to_reminders($id=null) {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        $id = $this->params['form']['id'];
        $updown = $this->params['form']['updown'];
        $this->xml_home = Configure::read('xml_home');
        $this->layout = Null;
        if (empty($this->params['form'])) {

            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],'voided'=>$this->params['form']['updown'],'timecard'=>0);
            if ($this->Invoice->save($this->data))
            {
                $jsonComp->move_void_to_reminders($id);
                echo '{"error_code":"0","message":"Invoice Unvoided Moved to Reminders"}';
            } else {
                echo '{"error_code":"3","message":"Invoice Not Moved to Reminders"}';
            }
        }
        exit;
    }/* called from radio buttons in reminders index */
    function soap_set_reminder_void($id=null) {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        $id = $this->params['form']['id'];
        $updown = $this->params['form']['updown'];
        $this->xml_home = Configure::read('xml_home');
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],'voided'=>$this->params['form']['updown']);
            if ($this->Invoice->save($this->data))
            {
                $jsonComp->move_reminder_to_void($id);
                echo '{"error_code":"0","message":"Invoice Voided"}';
            } else {
                echo '{"error_code":"3","message":"Invoice Not Voided"}';
            }
        }
        exit;
    }
    function soap_set_timecard_void($id=null) {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        $id = $this->params['form']['id'];
        $updown = $this->params['form']['updown'];
        $this->xml_home = Configure::read('xml_home');
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],'voided'=>$this->params['form']['updown']);
            if ($this->Invoice->save($this->data))
            {
                $jsonComp->move_timecard_to_void($id);
                echo '{"error_code":"0","message":"Invoice Voided"}';
            } else {
                echo '{"error_code":"3","message":"Invoice Not Voided"}';
            }
        }
        exit;
    }
    function soap_set_reminders_waiting_void($id=null) {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        $id = $this->params['form']['id'];
        $updown = $this->params['form']['updown'];
        $this->xml_home = Configure::read('xml_home');
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],'voided'=>$this->params['form']['updown']);
            if ($this->Invoice->save($this->data))
            {
                $jsonComp->move_timecard_to_void($id);
                echo '{"error_code":"0","message":"Invoice Voided"}';
            } else {
                echo '{"error_code":"3","message":"Invoice Not Voided"}';
            }
        }
        exit;
    }
    function soap_set_open_void($id=null) {
        $jsonComp = new JsonComponent;
        Configure::write('debug', 0);
        $id = $this->params['form']['id'];
        $updown = $this->params['form']['updown'];
        $this->xml_home = Configure::read('xml_home');
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],'voided'=>$this->params['form']['updown']);
            if ($this->Invoice->save($this->data))
            {
                $jsonComp->move_open_to_void($id);
                echo '{"error_code":"0","message":"Open Invoice Voided"}';
            } else {
                echo '{"error_code":"3","message":"Open Invoice Not Voided"}';
            }
        }
        exit;
    }
    /* called from buttons in reminders index */
    function soap_timecard_received() {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        $id = $this->params['form']['id'];
        $updown = $this->params['form']['updown'];
        $this->xml_home = Configure::read('xml_home');
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],'timecard'=>$this->params['form']['updown']);
            if ($this->Invoice->save($this->data))
            {
                $jsonComp->move_reminder_to_timecards($id);
                echo '{"error_code":"0","message":"Reminder converted to Timecard"}';
            } else {
                echo '{"error_code":"3","message":"Reminders not converted to timecard"}';
            }
        }
        exit;
    }
    /*
     * soap_save_invoice() - saves the reminder's edit form data
     */
    function soap_save_invoice()
    {
        $jsonComp = new JsonComponent;
        Configure::write('debug', 0);
        $this->data['Invoice'] = $this->params['data']['Invoice'];
        $this->data['Invoice']['date'] = $this->params['form']['date-date-year'].'-'.$this->params['form']['date-date-month'].'-'.$this->params['form']['date-date-day-of-month'];
        $this->data['Invoice']['period_start'] = $this->params['form']['period_start-date-year'].'-'.$this->params['form']['period_start-date-month'].'-'.$this->params['form']['period_start-date-day-of-month'];
        $this->data['Invoice']['period_end'] = $this->params['form']['period_end-date-year'].'-'.$this->params['form']['period_end-date-month'].'-'.$this->params['form']['period_end-date-day-of-month'];
        //debug($this->params);

        $user = $this->Auth->user();
        $this->data['Invoice']['modified_user_id'] =$user['User']['id'];
        $this->data['Invoice']['modified_date'] = date('Y-m-d');

        $this->Invoice->save_dynamic_ajax($this->data,$this->Session);
        App::import('Model', 'cache/reminder');
        $reminderModel = new ReminderCache;

        $out = $reminderModel->update_json_timecard($this->params['data']['Invoice']['id']);
        echo '{"error_code":"0","message":"Invoice Saved","inv":'.$out.'}';
        exit;
    }
    /*
     * soap_edit_invoice() - returns current state of an invoice, make sure to not repost
     */
    function soap_edit_invoice()
    {
        $jsonComp = new JsonComponent;
        Configure::write('debug', 0);
        debug($this->components);
        if ($inv = $this->Invoice->getInvoiceRec($this->params['form']['id']))
        {
            if($inv['Invoice']['posted'] == 1)
                echo '{"error_code":1 ,"message":"Invoice is posted!!"}';
            elseif($inv['Invoice']['voided'] == 1)
                echo '{"error_code":2 ,"message":"Invoice is voided!!"}';
            else
                echo '{"error_code":0 ,"message":"Invoice is good!!","inv":'.$this->Json->json_encode($inv).'}';

        }else{
            echo '{"error_code":3 ,"message":"Invoice does not exist!"}';
        }
        exit;
    }
    function soap_edit_notes()
    {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        //debug($this->params);
        $this->layout = Null;
        if (empty($this->params['form'])) {

            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $this->data['Invoice'] = array('id'=>$this->params['form']['id'],
                'notes'=>$this->params['form']['notes']
            );
            $this->params['form']['reminders'];
            if ($this->Invoice->save($this->data))
            {
                $reminders = json_decode($jsonComp->reminders_cached());
                $reminders_tmp = new stdClass();
                $reminders_tmp->reminders = Array();
                foreach($reminders->reminders as $reminder)
                {
                    if($reminder->id == $this->params['form']['id'])
                    {
                        $reminder->n = $this->params['form']['notes'];
                    }
                    $reminders_tmp->reminders[$reminder->id] = $reminder;
                }
                $jsonComp->cache_emailable_reminders($this->Json->json_encode($reminders_tmp));

                echo '{"error_code":"0","message":"Notes Saved"}';
            } else {

                echo '{"error_code":"3","message":"Notes Not Saved"}';
            }

        }


        exit;
    }
    function soap_invoice_item_list()
    {
        $jsonComp = new JsonComponent;
        Configure::write('debug',0);
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $inv = $this->Invoice->find('all',array('conditions'=>array('Invoice.id'=>$this->params['form']['id'])));
            echo $jsonComp->invoice_item_list($inv[0]['InvoicesItem']) ;
        }
        exit;
    }

    function soap_open_invoices()
    {
        // wont work without this!!!!
        Configure::write('debug', 0);
        $jsonComp = new JsonComponent;
        echo $jsonComp->opens_cached();
        $this->autoRender = false;
        return;
    }
    function soap_reminders_waiting()
    {
        // wont work without this!!!!
        Configure::write('debug', 0);
        $jsonComp = new JsonComponent;


        echo $jsonComp->reminders_waiting_cached();
        $this->autoRender = false;
        return;
    }
    function soap_timecards_receipts_pending()
    {
        Configure::write('debug', 0);
        $jsonComp = new JsonComponent;

        header('Content-type: application/json');

        $this->autoRender = false;
        return $jsonComp->timecard_receipts_pending_cached();
    }
    function soap_timecards_receipts_sent()
    {
        // wont work without this!!!!
        Configure::write('debug', 0);
        $jsonComp = new JsonComponent;
        echo $jsonComp->timecard_receipts_sent_cached();

        $this->autoRender = false;
        return;
    }
    function soap_voided_invoices()
    {
        // wont work without this!!!!
        Configure::write('debug', 0);
        $jsonComp = new JsonComponent;
        echo $jsonComp->voids_cached();

        $this->autoRender = false;
        return;
    }
    public function soap_send_timecard_receipt()
    {
        Configure::write('debug', 0);
        if(isset($this->params['form']['id']))
        {
            $id = $this->params['form']['id'];
        }

        if (!$id) {
            echo '{"error_code":"1","message":"Bad Invoice"}';
            exit;
        } else {

            $this->timecardRecieptComp->send_timecard_receipt($id);
            $this->jsonComp->move_pending_receipt_to_sent_receipt($id);
            echo '{"error_code":"0","message":"Reciept Sent"}';
        }

        exit;
    }
    function soap_post_invoice()
    {
        $id = $this->params['form']['id'];
        $this->invPostCom->post($id);
        echo '{"error_code":"0","message":"Invoice Posted"}';

        exit;
    }

    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'soap_timecard_received',
                'soap_set_reminder_void',
                'soap_edit_notes',
                'soap_edit_invoice',
                'soap_save_invoice',
                'soap_set_timecard_void',
                'soap_set_reminders_waiting_void',
                'soap_set_open_void',
                'soap_void_push_to_reminders',
                'soap_invoice_item_list',
                'soap_reminders_waiting',
                'soap_open_invoices',
                'soap_timecards_receipts_pending',
                'soap_timecards_receipts_sent',
                'soap_voided_invoices',
                'soap_post_invoice',
                'soap_send_timecard_reciept',
            ))){
            Configure::write('debug', 0);
            Configure::write('Security.level', 'medium');
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}


?>
