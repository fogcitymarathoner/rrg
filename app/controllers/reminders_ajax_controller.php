<?php
App::import('Component', 'InvoiceFunction');

App::import('Model', 'cache/reminder');

App::import('Component', 'Json');

class RemindersAjaxController  extends AppController {
	var $name = 'RemindersAjax';
    var $page_title ;
	var $uses = array('Invoice','Reminder');
    var $paginate = array(
         'limit' => 10,
         'contain' => array('Invoice'),
   		'order'=>array('date' => 'desc'),
   		'conditions'=>array('posted' => 1,'voided' => 0),        
    );
    public function __construct() {

        $this->invoiceFunction = new InvoiceFunctionComponent;
        $this->jsonComp = new JsonComponent;
        $this->reminderModel = new ReminderCache;
        parent::__construct();
    }

    function index() {
        $jsfile_template = APP.WEBROOT_DIR.DS.'js'.DS.'reminders_template.js';
        $fin = fopen($jsfile_template,'r');

        $fsize = filesize($jsfile_template);
        $template_script  = fread($fin,$fsize);
        fclose($fin);
        $clients_json = $this->jsonComp->clients_cached();
        $employees_json = $this->jsonComp->employees_cached();
        $contracts_json = $this->jsonComp->contracts_cached();
        $settings_json = $this->jsonComp->ajax_settings($this->webroot);

        $one = 1;

        $script = str_replace ("'CLIENTS'", $clients_json, $template_script, $one);
        $script = str_replace ("'EMPLOYEES'", $employees_json, $script, $one);
        $script = str_replace ("'CONTRACTS'", $contracts_json, $script, $one);
        $script = str_replace ("'SETTINGS'", $settings_json, $script, $one);

        $this->set(compact('script'));
    }
    function soap_reminderlist()
    {
        echo $this->jsonComp->reminders_cached();
        $this->autoRender = false;
        return;
    }
    function soap_timecardlist()
    {
        echo $this->jsonComp->timecards_cached();
        $this->autoRender = false;
        return;
    }
	function soap_email($id=null)
	{
        $this->layout = Null;
        if (empty($this->params['form'])) {
            echo '{"error_code":"1","message":"empty form"}';
        } else
        {
            $id = $this->params['form']['id'];
            if ($id) {
                $this->data = $this->Invoice->read(null, $id);
                $this->Invoice->unbindEmployeeModelForInvoicing();
                $employee=$this->Invoice->ClientsContract->Employee->read(null, $this->data['ClientsContract']['employee_id']);
                $period = $this->invoiceFunction->period_formatted($this->data);
                $this->Email->subject = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].
                    ": We have not received your timecard for the period ".$period[0].' to '.$period[1];
                $this->Email->body = "Please get that to timecards@rocketsredglare.com as soon as possible.<br>Thanks<br>Monica Fey";
                $this->Email->from         = 'timecards@rocketsredglare.com';
                $this->Email->fromName     = "Rockets Redglare Timecards";
                foreach ($employee['EmployeesEmail'] as $email):
                    $this->Email->to = $email['email'];
                    $this->Email->toName = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                    $result = $this->Email->send();
                    $this->Invoice->InvoicesTimecardReminderLog->create();
                    $reminderlog = array();
                    $reminderlog['InvoicesTimecardReminderLog']['invoice_id'] = $this->data['Invoice']['id'];
                    $reminderlog['InvoicesTimecardReminderLog']['email'] = $email['email'];
                    $reminderlog['InvoicesTimecardReminderLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
                    $this->Invoice->InvoicesTimecardReminderLog->save($reminderlog);

                    $new_rec = $reminderModel->update_json_reminder($this->data['Invoice']['id']);


                endforeach;
                $this->Email->to = 'timecardtest@fogtest.com';
                $result = $this->Email->send();
                #$this->redirect(array('action'=>'index'));
                echo '{"error_code":"0", "reminder": '.$new_rec.'}';
            }
        }
        exit;
	}

    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'edit_invoice',
                'm_edit_invoice',
                'soap_email',
                'soap_reminderlist',
                'soap_timecardlist',
        ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}
