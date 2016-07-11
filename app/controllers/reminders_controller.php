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
App::import('Component', 'Reminders');

App::import('Model', 'cache/invoice');
App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsReportsTag');
App::import('Model', 'CommissionsPayment');
App::import('Model', 'Note');
App::import('Model', 'NotesPayment');
App::import('Model', 'Invoice');


class RemindersController  extends AppController {
	var $name = 'Reminders';
    var $page_title ;
	var $uses = array('Reminder');
    var $paginate = array(
         'limit' => 10,
         'contain' => array('Invoice'),
   		'order'=>array('date' => 'desc'),
   		'conditions'=>array('posted' => 1,'voided' => 0),        
    );
    //
    public function __construct() {

        $this->timecardRecieptComp = new TimecardReceiptComponent;
        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->empModel = new Employee;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;

        $this->invoiceFunction = new InvoiceFunctionComponent;
        $this->reminders = new RemindersComponent;
        
        $this->xml_home = Configure::read('xml_home');

        $this->server = Configure::read('server');
        $this->commItemModel = new InvoicesItemsCommissionsItem;
        $this->commPayModel = new CommissionsPayment;
        $this->noteModel = new Note;
        $this->notesPaymentModel = new NotesPayment;
        $this->commRptTagModel = new CommissionsReportsTag;
        $this->Invoice = new Invoice;
        parent::__construct();
    }


    private function open_invoices()
    {
        App::import('Component', 'DateFunction');

        $dateF = new DateFunctionComponent();



        $this->Invoice = new Invoice;
        $this->Invoice->recursive = 2;
        $open = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,
                    'cleared'=>0,
                    'posted'=>1,
                    'mock' => 0,
                    'amount >0'),
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
        //debug($open);exit;
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
            }//debug($open[$count]['Invoice']); exit;
            $count++;
        endforeach;
        return $open;
    }



    private function unsent_timecard_receipts()
    {
        App::import('Component', 'DateFunction');

        $dateF = new DateFunctionComponent();


        $this->Invoice->recursive = 2;

        $open = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,
                    'cleared'=>0,
                    'posted'=>1,
                    'timecard_receipt_sent'=>0,
                    'prcleared'=>0,
                    'amount >0'),
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
        //debug($open);exit;
        $count = 0;
        foreach ($open as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))   , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
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
            $open[$count]['EmployeeEmail'] = $this->Invoice->ClientsContract->Employee->EmployeesEmail->find('all', array('conditions'=>array('employee_id'=>$open[$count]['ClientsContract']['employee_id'])));
            $open[$count]['InvoicesTimecardReceiptLog'] = $this->Invoice->InvoicesTimecardReceiptLog->find('all', array('conditions'=>array('Invoice.id'=>$open[$count]['Invoice']['id'])));

            $count++;
        endforeach;
        return $open;
    }
    private function sent_timecard_receipts()
    {
        App::import('Component', 'DateFunction');

        $dateF = new DateFunctionComponent();

        $this->Invoice->recursive = 2;

        $open = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,
                    'cleared'=>0,
                    'posted'=>1,
                    'timecard_receipt_sent'=>1,
                    'prcleared'=>0,
                    'amount >0'),
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
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))   , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
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
            $open[$count]['EmployeeEmail'] = $this->Invoice->ClientsContract->Employee->EmployeesEmail->find('all', array('conditions'=>array('employee_id'=>$open[$count]['ClientsContract']['employee_id'])));
            $open[$count]['InvoicesTimecardReceiptLog'] = $this->Invoice->InvoicesTimecardReceiptLog->find('all', array('conditions'=>array('Invoice.id'=>$open[$count]['Invoice']['id'])));

            $count++;
        endforeach;
        //debug($open);exit;
        return $open;
    }
    private function timecard_receipts()
    {
        App::import('Component', 'DateFunction');

        $dateF = new DateFunctionComponent();

        $this->recursive = 2;
        $this->unbindContractModelForInvoicing();
        $this->unbindModel(array('hasMany' =>
            array(
                'InvoicesItem',
                'InvoicesPayment',
                'EmployeesPayment',
                'InvoicesTimecardReminderLog',
                'InvoicesPostLog',
                'ClientsManager'),),false);
        $open = $this->find('all', array(
                'conditions'=>array('voided'=>0,
                    'cleared'=>0,
                    'posted'=>1,
                    'timecard_receipt_sent'=>1,
                    'amount >0'),
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
        //debug($open);exit;
        $count = 0;
        foreach ($open as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))   , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
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
            $open[$count]['EmployeeEmail'] = $this->ClientsContract->Employee->EmployeesEmail->find('all', array('conditions'=>array('employee_id'=>$open[$count]['ClientsContract']['employee_id'])));
            $open[$count]['InvoicesTimecardReceiptLog'] = $this->InvoicesTimecardReceiptLog->find('all', array('conditions'=>array('Invoice.id'=>$open[$count]['Invoice']['id'])));

            $count++;
        endforeach;
        return $open;
    }
    function index() {
        Configure::write('debug', 0);
        # Setup Reminders
        $reminders = $this->reminders->reminders();
        $this->set(compact('reminders'));
    }
    function m_index() {
        Configure::write('debug',0);
        $this->layout = "default_jqmobile";
        # Setup Reminders
        $reminders = $this->reminders->reminders();
        $page_title = 'Timecard Reminders';
        $this->set(compact('reminders','page_title'));
        $this->render('/reminders/m/index');
    }
    function timecards() {
        Configure::write('debug',0);
		# Setup Timecards for time entry
		$timecards = $this->reminders->get_timecards();
		$this->set(compact('timecards'));
	}
    function m_timecards() {
        $this->layout = "default_jqmobile";
        # Setup Timecards for time entry
        $timecards = $this->timecards();
        $page_title = 'Timecards';
        $this->set(compact('timecards','page_title'));
        $this->render('/reminders/m/timecards');
    }
    function opens() {
        Configure::write('debug',0);
		# setup open posted invoices
		$opens = $this->open_invoices();
		$this->set(compact('opens'));
	}
    function m_opens() {
        $this->layout = "default_jqmobile";
        # setup open posted invoices
        $opens = $this->open_invoices();
        $page_title = 'Open Invoices';
        $this->set(compact('opens','page_title'));
        $this->render('/reminders/m/opens');
    }
    function timecard_receipts_pending() {
        Configure::write('debug',0);
		# setup invoices where timecard reciept was not sent out
		$this->data = $this->unsent_timecard_receipts();
	}	
		
    function timecard_receipts_sent() {
        Configure::write('debug',0);
		# setup invoices where timecard reciept was not sent out
		$this->data = $this->sent_timecard_receipts();
	}	
	
	function transition_timecard($id=null)  
	{
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Invoice', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->Invoice->timecard($id);
		$this->redirect(array('action'=>'index'));
	}
	function email($id=null)  
	{
        Configure::write('debug', 0);
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Invoice', true));
			$this->redirect(array('action'=>'index'));
		}

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
			
			endforeach; 
			$this->Email->to = 'timecardtest@fogtest.com';           	
			$result = $this->Email->send(); 
			$this->redirect(array('action'=>'index'));            
		}
	}
	function edit($id = null) {
		$this->Invoice->recursive = 2;
		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Invoice->updateTotalPrepost($id);
		$this->data = $this->Invoice->read(null, $id); 
		$invoicesItems = $this->Invoice->InvoicesItem->find('all', array('conditions'=>array('invoice_id'=>$this->data['Invoice']['id'])));
		$this->set(compact('invoicesItems'));
		
	}
	function edit_invoice($step=1, $invoice_id)
	{
        Configure::write('debug',2);


		$this->set(compact('step'));
		if($step == 1) // Generate contract list of client, pick Contract
		{	
			$this->data = $this->Invoice->getInvoiceOldEdit($invoice_id); 
			#$this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());
		}
		if($step == 2) // recommit data
		{
            //debug($this->data);exit;
			//$this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());
	
			if($this->data['Invoice']['id'])
			{
                $dateex = explode('/',$this->data['Invoice']['date']);
                $this->data['Invoice']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $dateex = explode('/',$this->data['Invoice']['period_start']);
                $this->data['Invoice']['period_start'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $dateex = explode('/',$this->data['Invoice']['period_end']);
                $this->data['Invoice']['period_end'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];

                $user = $this->Auth->user();
                $this->data['Invoice']['modified_user_id'] =$user['User']['id'];
                $this->data['Invoice']['modified_date'] = date('Y-m-d');

				$this->Invoice->save_dynamic($this->data,$this->Session);
				
				//$this->data = $this->Invoice->getInvoiceReview($this->data['Invoice']['id']);

				$this->redirect(array('action'=>'timecards'));
			} else {
				$this->data = $this->Invoice->getInvoiceReview($invoice_id);
			}
		}
	}

    function m_edit_invoice($step=1, $invoice_id)
    {
        $this->layout = "default_jqmobile";
        $this->set(compact('step'));
        if($step == 1) // Generate contract list of client, pick Contract
        {
            $this->data = $this->Invoice->getInvoiceReview($invoice_id);
            $this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());
        }
        if($step == 2) // recommit data
        {
            $this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());

            if($this->data['Invoice']['id'])
            {
                $dateex = explode('/',$this->data['Invoice']['date']);
                $this->data['Invoice']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $dateex = explode('/',$this->data['Invoice']['period_start']);
                $this->data['Invoice']['period_start'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $dateex = explode('/',$this->data['Invoice']['period_end']);
                $this->data['Invoice']['period_end'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $this->data['Invoice']['modified_date'] =  date('Y-m-d H:i:s');

                $user = $this->Auth->user();
                $this->data['Invoice']['modified_user_id'] = $user['User']['id'];
                $this->Invoice->save_dynamic($this->data,$this->Session);

                $this->data = $this->Invoice->getInvoiceReview($this->data['Invoice']['id']);
            } else {
                $this->data = $this->Invoice->getInvoiceReview($invoice_id);
            }
        }
        $this->render('/reminders/m/edit_invoice');
    }
    function edit_invoice_mootools($step=1, $invoice_id)
    {

        $this->layout = 'default_moodaterange';
        $this->set(compact('step'));
        if($step == 1) // Generate contract list of client, pick Contract
        {
            $this->data = $this->Invoice->getInvoiceReview($invoice_id);
            $this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());
        }
        if($step == 2) // recommit data
        {
            $this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());

            if($this->data['Invoice']['id'])
            {
                $dateex = explode('/',$this->data['Invoice']['date']);
                $this->data['Invoice']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $dateex = explode('/',$this->data['Invoice']['period_start']);
                $this->data['Invoice']['period_start'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $dateex = explode('/',$this->data['Invoice']['period_end']);
                $this->data['Invoice']['period_end'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
                $this->Invoice->save_dynamic($this->data,$this->Session);

                $this->data = $this->Invoice->getInvoiceReview($this->data['Invoice']['id']);
            } else {
                $this->data = $this->Invoice->getInvoiceReview($invoice_id);
            }//debug($this->data);exit;
        }
    }
    function edit_notes($invoice_id,$next)
	{
	    if (empty($this->data)) {
	    	
			$this->data = $this->Invoice->getInvoiceReview($invoice_id); 
			$this->set('next',$next);
	    } else 
	    {
	    	$this->Invoice->save($this->data);
			$this->redirect(array('action'=>$this->data['Invoice']['next']));
	    }
	}
	function edit_item($id = null) {
		$this->Invoice->InvoicesItem->recursive = 2;
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Reminder', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Invoice->InvoicesItem->save($this->data)) {
				$this->Session->setFlash(__('The Reminder has been saved', true));
				$this->Invoice->updateTotalPrepost($this->data['InvoicesItem']['invoice_id']);
				$this->redirect(array('action'=>'edit/',$this->data['InvoicesItem']['invoice_id']));
			} else {
				$this->Session->setFlash(__('The Reminder could not be saved. Please, try again.', true));
			}
		}
		$this->data = $this->Invoice->InvoicesItem->read(null, $id);
	}
	
   	function rebuild_invoice($id = null)
	{

		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Invoice->rebuild_invoice($id);
		$this->redirect(array('action'=>'edit_invoice/1/'.$id));
	}
    function m_rebuild_invoice($id = null)
    {
        $this->layout = "default_jqmobile";
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Invoice->rebuild_invoice($id);
        $this->redirect(array('prefix'=>'m','action'=>'edit_invoice/1/'.$id));
    }
   	function rebuild_invoice_items($id = null)
	{
        App::import('Model', 'Invoice');
        $this->Invoice = new Invoice;
		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Invoice->rebuild_invoice($id);
		$this->redirect(array('action'=>'edit/'.$id));
	}

    function view_invoice_pdf($id,$display= null)
    {
        $this->Invoice->generatepdf($id,1,$this->xml_home);
        $this->redirect(array('action'=>'edit_invoice/2/'.$id));
    }

    function m_view_invoice_pdf($id,$display= null)
    {
        $this->Invoice->generatepdf($id,1,$this->xml_home);
        $this->redirect(array('prefix'=>'m','action'=>'edit_invoice/2/'.$id));
    }

    function view_invoices_item($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoicesItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoicesItem', $this->Invoice->InvoicesItem->read(null, $id));
	}	
	function view_open_invoice($id=null)  
	{
        Configure::write('debug',2);
        $this->layout = "default_jqmobile";
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Invoice', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->data = $this->Invoice->read(null, $id);
		$employee =  $this->Invoice->employeeForInvoicing($this->data['ClientsContract']['employee_id']);	
		$subject =  $this->invoiceFunction->email_subject($this->data, $employee);
		$invoiceurltoken = $this->invoiceFunction->invoiceTokenUrl($this->data, $subject, $this->server, $employee);

		$this->data['Invoice']['urltoken'] = $invoiceurltoken;

        $page_title = 'View Invoice';
        $this->set(compact('page_title'));
	}

    function m_view_open_invoice($id=null)
    {
        $this->layout = "default_jqmobile";
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }

        $this->data = $this->Invoice->read(null, $id);
        $employee =  $this->Invoice->employeeForInvoicing($this->data['ClientsContract']['employee_id']);
        $subject =  $this->invoiceFunction->email_subject($this->data, $employee);


        $invoiceurltoken = $this->invoiceFunction->invoiceTokenUrl($this->data, $subject, $this->server, $employee);
        $this->data['Invoice']['urltoken'] = $invoiceurltoken;

        $this->page_title = 'View Open Invoice';
        $this->render('/reminders/m/view_open_invoice');
        $page_title = 'View Invoice';
        $this->set(compact('page_title'));
    }

    function delete_item($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Item', true));
			$this->redirect(array('action'=>'index'));
		} 
		
		$item = $this->Invoice->InvoicesItem->read(null,$id); //debug($item);exit;
		if ($this->Invoice->InvoicesItem->delete($id)) {
			$this->Session->setFlash(__('Item deleted', true));
			$this->redirect(array('action'=>'edit','id'=>$item['Invoice']['id']));
		}
	}
	
	function post($id=null)  
	{

        
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Invoice', true));
			$this->redirect(array('action'=>'index'));
		}
	    	
		if (empty($this->data)) {
	 		
	        $invoice = $this->Invoice->mark_posted($id);

		    // Contract
			$contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);
            // Client
            $client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
            // Employee
            $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);
			
			$filename = 'rocketsredglare_invoice_'.$invoice['Invoice']['id'].'_'.$employee['Employee']['firstname'].'_'.$employee['Employee']['lastname'].'_'.$invoice['Invoice']['period_start'].'_to_'.$invoice['Invoice']['period_end'].'.pdf';
			$this->generatepdf($invoice['Invoice']['id'],null, $this->xml_home);

	   		$this->Email->to = 'invoicetest@fogtest.com';
	   		$this->Email->toName = 'Invoice Tester';

	   		$subject = $this->invoiceFunction->email_subject($invoice, $employee);
	   		$filename = $this->invoiceFunction->invoiceFilename($invoice,$employee);	
	        $fully_qualified_filename =$this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);
	   		$this->Email->subject = $subject;
	        $this->Email->from         = 'timecards@rocketsredglare.com';
	        $this->Email->fromName     = "Rockets Redglare Invoices";
	        $this->Email->attach($fully_qualified_filename, $filename);


	        $this->Email->body = $this->invoiceFunction->emailBody($invoice,$subject,$employee, $this->server);
	        $result = $this->Email->send();
			foreach ($contract['ClientsManager'] as $email):
			   	$this->Email->to = $email['email'];
			   	$this->Email->toName = $email['firstname'].' '.$email['firstname'];
				$result = $this->Email->send();
				$this->Invoice->InvoicesPostLog->create();
				$reminderlog = array();
				$reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
				$reminderlog['InvoicesPostLog']['email'] = $email['email'];
				$reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
				$this->Invoice->InvoicesPostLog->save($reminderlog);
			endforeach; 
	 		foreach ($contract['User'] as $email):
			   	$this->Email->toName = $email['firstname']. ' '.$email['lastname'];
			   	$this->Email->to = $email['email'];
				$result = $this->Email->send();
				$this->Invoice->InvoicesPostLog->create();
				$reminderlog = array();
				$reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
				$reminderlog['InvoicesPostLog']['email'] = $email['email'];
				$reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
				$this->Invoice->InvoicesPostLog->save($reminderlog);
			endforeach; 
			$this->redirect(array('action'=>'timecards'));            
		}
	}

    function m_post($id=null)
    {
        $this->layout = "default_jqmobile";
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }

        if (empty($this->data)) {


            $invoice = $this->Invoice->mark_posted($id);

            // Contract
            $contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);
            // Client
            $client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
            // Employee
            $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);

            $filename = 'rocketsredglare_invoice_'.$invoice['Invoice']['id'].'_'.$employee['Employee']['firstname'].'_'.$employee['Employee']['lastname'].'_'.$invoice['Invoice']['period_start'].'_to_'.$invoice['Invoice']['period_end'].'.pdf';
            $this->generatepdf($invoice['Invoice']['id']);


            $this->Email->to = 'invoicetest@fogtest.com';
            $this->Email->toName = 'Invoice Tester';

            $subject = $this->invoiceFunction->email_subject($invoice, $employee);
            $filename = $this->invoiceFunction->invoiceFilename($invoice,$employee);
            $fully_qualified_filename =$this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);


            $this->Email->subject = $subject;
            $this->Email->from         = 'timecards@rocketsredglare.com';
            $this->Email->fromName     = "Rockets Redglare Invoices";
            $this->Email->attach($fully_qualified_filename, $filename);


            $this->Email->body = $this->invoiceFunction->emailBody($invoice,$subject,$employee, $this->server);
            $result = $this->Email->send();
            foreach ($contract['ClientsManager'] as $email):
                $this->Email->to = $email['email'];
                $this->Email->toName = $email['firstname'].' '.$email['firstname'];
                $result = $this->Email->send();
                $this->Invoice->InvoicesPostLog->create();
                $reminderlog = array();
                $reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
                $reminderlog['InvoicesPostLog']['email'] = $email['email'];
                $reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
                $this->Invoice->InvoicesPostLog->save($reminderlog);
            endforeach;
            foreach ($contract['User'] as $email):
                $this->Email->toName = $email['firstname']. ' '.$email['lastname'];
                $this->Email->to = $email['email'];
                $result = $this->Email->send();
                $this->Invoice->InvoicesPostLog->create();
                $reminderlog = array();
                $reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
                $reminderlog['InvoicesPostLog']['email'] = $email['email'];
                $reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
                $this->Invoice->InvoicesPostLog->save($reminderlog);
            endforeach;
            $this->redirect(array('prefix'=>'m','action'=>'timecards'));
        }
    }
	function resend_to_staff($id=null)  
    {
        Configure::write('debug', 2);
        if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Invoice', true));
			$this->redirect(array('action'=>'index'));
		}
	    	
		if (empty($this->data)) {

            App::import('Model', 'invoice');

            $this->Invoice = new Invoice;
            $invoice = $this->Invoice->mark_posted($id);
           	
			// Contract
			$contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);

            // Client
            $client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
            // Employee
            $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);

	   		$this->Email->to = 'invoicetest@fogtest.com';
	   		$this->Email->toName = 'Invoice Tester';
			
	   		$subject = $this->invoiceFunction->email_subject($invoice, $employee);
	   			
	   		$this->Email->subject = $subject;
	
	        $this->Email->from         = 'timecards@rocketsredglare.com';
	        $this->Email->fromName     = "Rockets Redglare Invoices";
	        $this->Email->body = 'Please get that to us.  Thanks in advance.';

			
	   		$subject = $this->invoiceFunction->email_subject($invoice, $employee);
	   		$filename = $this->invoiceFunction->invoiceFilename($invoice,$employee);	
	        $fully_qualified_filename =$this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);
	        $new_name_when_attached=$filename; //optional
	        $this->Email->attach($fully_qualified_filename, $new_name_when_attached);


	        $this->Email->body = $this->invoiceFunction->emailBody($invoice, $subject, $employee, $this->server);
	        $result = $this->Email->send();
	 		foreach ($contract['User'] as $email):
			   	$this->Email->toName = $email['firstname']. ' '.$email['lastname'];
			   	$this->Email->to = $email['email'];
				$result = $this->Email->send();
				$this->Invoice->InvoicesPostLog->create();
				$reminderlog = array();
				$reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
				$reminderlog['InvoicesPostLog']['email'] = $email['email'];
				$reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
				$this->Invoice->InvoicesPostLog->save($reminderlog);
			endforeach; 
			$this->redirect(array('action'=>'opens'));            
		}
	}
    /*
     * This cannot be used for previewing because it mark the invoice posted
     */
    function m_resend_to_staff($id=null)
    {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }
        if (empty($this->data)) {
            // You can use customised thmls or the default ones you setup at the start
            $invoice = $this->Invoice->mark_posted($id);
            // Contract
            $contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);
            // Client
            $client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
            // Employee
            $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);
            $this->Email->to = 'invoicetest@fogtest.com';
            $this->Email->toName = 'Invoice Tester';

            $subject = $this->invoiceFunction->email_subject($invoice, $employee);
            $this->Email->subject = $subject;

            $this->Email->from         = 'timecards@rocketsredglare.com';
            $this->Email->fromName     = "Rockets Redglare Invoices";
            $this->Email->body = 'Please get that to us.  Thanks in advance.';
            $subject = $this->invoiceFunction->email_subject($invoice, $employee);
            $filename = $this->invoiceFunction->invoiceFilename($invoice,$employee);
            $fully_qualified_filename =$this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);
            $new_name_when_attached=$filename; //optional
            $this->Email->attach($fully_qualified_filename, $new_name_when_attached);

            $this->Email->body = $this->invoiceFunction->emailBody($invoice,$subject,$employee, $this->server);
            $result = $this->Email->send();
            foreach ($contract['User'] as $email):
                $this->Email->toName = $email['firstname']. ' '.$email['lastname'];
                $this->Email->to = $email['email'];
                $result = $this->Email->send();
                $this->Invoice->InvoicesPostLog->create();
                $reminderlog = array();
                $reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
                $reminderlog['InvoicesPostLog']['email'] = $email['email'];
                $reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
                $this->Invoice->InvoicesPostLog->save($reminderlog);
            endforeach;
            $this->redirect(array('prefix'=>'m','action'=>'opens'));
        }
    }

    function m_resend_to_staff_without_posting($id=null)
    {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }

        if (empty($this->data)) {
            //$this->Email->template = 'email/confirm';
            // You can use customised thmls or the default ones you setup at the start

            $invoice = $this->Invoice->read(null, $id);

            $invoice['Invoice']['date']   =date('Y-m-d');
            $this->Invoice->save($invoice);

            // Contract
            $contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);

            // Client
            $client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
            // Employee
            $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);



            $this->Email->to = 'invoicetest@fogtest.com';
            $this->Email->toName = 'Invoice Tester';



            $subject = $this->invoiceFunction->email_subject($invoice, $employee);

            $this->Email->subject = $subject;

            $this->Email->from         = 'timecards@rocketsredglare.com';
            $this->Email->fromName     = "Rockets Redglare Invoices";
            $this->Email->body = 'Please get that to us.  Thanks in advance.';


            $subject = $this->invoiceFunction->email_subject($invoice, $employee);
            $filename = $this->invoiceFunction->invoiceFilename($invoice,$employee);
            $fully_qualified_filename =$this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);
            $new_name_when_attached=$filename; //optional
            $this->Email->attach($fully_qualified_filename, $new_name_when_attached);
            $this->Email->body = $this->invoiceFunction->emailBody($invoice,$subject,$employee, $this->server);
            $result = $this->Email->send();
            foreach ($contract['User'] as $email):
                $this->Email->toName = $email['firstname']. ' '.$email['lastname'];
                $this->Email->to = $email['email'];
                $result = $this->Email->send();
                $this->Invoice->InvoicesPostLog->create();
                $reminderlog = array();
                $reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
                $reminderlog['InvoicesPostLog']['email'] = $email['email'];
                $reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
                $this->Invoice->InvoicesPostLog->save($reminderlog);
            endforeach;
            $this->redirect(array('prefix'=>'m','action'=>'timecards'));
        }
    }

    function send_timecard_receipt($id=null)
	{
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Invoice', true));
			$this->redirect(array('action'=>'index'));
		}

		if ($id) {

            $this->timecardRecieptComp->send_timecard_receipt($id);
			$this->redirect(array('action'=>'timecard_receipts_pending'));
		}
	}
	function generatepdf($id,$display= null)
   	{
   		$this->Invoice->generatepdf($id,$display,$this->xml_home);
   	}

   	function previewpdf($id)
   	{

   		$this->Invoice->generatepdf($id,1,$this->xml_home);
   	}
    function m_previewpdf($id)
    {
        $this->Invoice->m_generatepdf($id,1,$this->xml_home);
    }
    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
            'timecard',
            'void',
            'edit_invoice',
            'm_edit_invoice',
        ))){
            Configure::write('debug', 0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}
