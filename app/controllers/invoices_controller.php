<?php
App::import('Component', 'Json');
App::import('Component', 'InvoiceFunction');
App::import('Model', 'Client');
class InvoicesController extends AppController {
	var $name = 'Invoices';
	var $page_title ;	
    var $paginate = array(
         'limit' => 20,
         'contain' => array('Invoice'),
   		'order'=>array('date' => 'desc'),
    );

    //
    public function __construct() {

        $this->invoiceFunction = new InvoiceFunctionComponent;
        $this->jsonComp = new JsonComponent;
		$this->Client = new Client;
        parent::__construct();
    }
	public function index() {
		$this->Invoice->recursive = 2;		
		$this->Invoice->unbindContractModelForInvoicing();		
		$this->Invoice->unbindModel(array('hasMany' => 
						array('InvoicesItem',
								'InvoicesPayment',
								'EmployeesPayment',
								'InvoicesTimecardReminderLog',
								'InvoicesPostLog',
								'ClientsManager'),),false);
        $this->Invoice->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager', ),),false);
        $this->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager', ),),false);
		$this->paginate['conditions'] = array(
   			'voided' => 0,
            'mock' => 0,
            'posted' => 1,
    	);
        $this->paginate['fields'] = array(
          'Invoice.id',
            'Invoice.period_start',
            'Invoice.period_end',
            'Invoice.date',
            'Invoice.amount',
            'Invoice.notes',
            'ClientsContract.employee_id',
            'ClientsContract.client_id'

        );
        
        $this->set('employees', $this->jsonComp->employees_cached());
        $this->set('clients', $this->jsonComp->clients_cached());
		$invoices = $this->paginate();
        $this->set('invoicesJS', $this->jsonComp->json_invoices_frontend($invoices)  );
		$this->set('invoices', $invoices);
        $this->set(compact('clientNames'));	
		$this->page_title = 'Invoices';
		$this->page_title = 'All Posted Invoices';
	}
	public function index_pastdue() {
		$invoices = $this->Invoice->open_invoices();

		$this->set('invoices', $invoices);
		$this->set('clientNames', $this->Client->find('list', array()));
		$this->page_title = 'Past Due Invoices';	
	}
	public function index_open() {
		$invoices = $this->Invoice->open_invoices();

		$this->set('invoices', $invoices);


        $this->set('clientNames', $this->Client->find('list', array()));
		$this->page_title = 'Open Invoices';
	}
	public function index_cleared() {
		$invoices = $this->Invoice->cleared_invoices();

		$this->set('invoices', $invoices);
        $this->set(compact('clientNames'));	
		$this->page_title = 'Cleared Invoices';
	}
	public function index_voided() {
		$invoices = $this->Invoice->voided_invoices();

		$this->set('invoices', $invoices);
		$this->set('clientNames', $this->Client->find('list', array()));
		$this->page_title = 'Voided Invoices';
	}
	public function rebuild_invoice($id = null)
	{
		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Invoice->rebuild_invoice($id);
		$this->redirect(array('action'=>'edit/'.$id));
	}

	public function view($id = null) {
		$this->Invoice->recursive = 2;
		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Invoice->unbindForInvoiceIndexApp();
        $invoice = $this->Invoice->read(null, $id);

		if($invoice['Invoice']['posted'])
		{	
			$this->Invoice->updateTotal($id);
		} else 
		{
			$this->Invoice->updateTotalPrepost($id);
		}
		# pick up status changes	
		$this->Invoice->recursive = 2;

        $invoice = $this->Invoice->read(null, $id);

		$this->Invoice->unbindContractModelForInvoicing();
		$invoicepayment = $this->Invoice->InvoicesPayment->find('all', array('conditions'=>array('InvoicesPayment.invoice_id'=>$id)));

		if (!empty($invoicepayment))
		{	
			$paymentTotal =0;
			foreach ($invoicepayment as $payment): 
					$paymentTotal += $payment['InvoicesPayment']['amount'];
			endforeach;	
			$invoice['Invoice']['balance'] = $invoice['Invoice']['amount'] - $paymentTotal;
			$invoice['Invoice']['totalpayment'] = $paymentTotal;
		} else 
		{	
			$invoice['Invoice']['balance'] = $invoice['Invoice']['amount'];
			$invoice['Invoice']['totalpayment'] = 0;
		}

		if (!empty($invoice['InvoicesItem']))
		{	
			$wageTotal =0;
			foreach ($invoice['InvoicesItem'] as $item):
                $this->Invoice->InvoicesItem->InvoicesItemsCommissionsItem->unbindModel(array('belongsTo' => array('InvoicesItem',
                    'CommissionsReport'),),false);

                foreach($this->Invoice->InvoicesItem->InvoicesItemsCommissionsItem->find('all', array('conditions'=>
                    array('invoices_item_id'=>$item['id']))) as $comm)
                    $invoice['InvoicesItem']['InvoicesItemsCommissionsItem'][] = $comm;
					$wageTotal += $item['quantity']*$item['cost'];
			endforeach;	
			$invoice['Invoice']['wagetotal'] = $wageTotal;
		} else 
		{	
			$invoice['Invoice']['wagetotal'] = 0;
		}

		if (!empty($invoice['EmployeesPayment']))
		{	
			$paymentTotalEmployee =0;
			foreach ($invoice['EmployeesPayment'] as $payment): 
					$paymentTotalEmployee += $payment['amount'];
			endforeach;	
			$invoice['Invoice']['employeeTotalPay'] =  $paymentTotalEmployee;
		} 
		$this->data =$invoice;
		$this->data['InvoicesPayment']  =array();
		if (!empty($invoicepayment))
		{	
			for ($a=0; count($invoicepayment)> $a; $a++)
			{
					$this->data['InvoicesPayment'][$a] =$invoicepayment[$a]['InvoicesPayment'];
					$this->data['InvoicesPayment'][$a]['ClientsCheck'] =$invoicepayment[$a]['ClientsCheck'];
			}	
		}		
		$contract = $this->Invoice->ClientsContract->client($invoice['Invoice']['contract_id'] );
		$this->page_title = 'View Invoice: '.$this->data['Invoice']['id'].'-'.$contract['Client']['name'].' - '.$contract['Employee']['firstname'].' '.$contract['Employee']['lastname'];
        $empsDB = $this->Invoice->ClientsContract->Employee->find('all',array('conditions'=>array('salesforce'=>1)));

        $employees = array();
        foreach($empsDB as $emp)
        {
            $employees[$emp['Employee']['id']] = $emp['Employee']['firstname'].' '.$emp['Employee']['lastname'];
        }

        $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);

        $subject =  $this->invoiceFunction->email_subject($invoice, $employee);

        $invoiceurltoken = $this->invoiceFunction->invoiceTokenUrl($invoice,$subject,$this->webroot,$employee);

        $this->set(compact('employees','invoiceurltoken', 'contract'));

	}
	public function printview_html($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Invoice->updateTotal($id);
		$invoice = $this->Invoice->read(null, $id);
		$this->set('invoice', $invoice);
		// Contract
		$contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);

		// Client
		$client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
		
		// View IT!!
		$this->layout='default_nomenu_nocss';
		$css=$this->webroot;
		$this->set(compact('client','css','id'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Invoice', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Invoice->delete($id)) {
			$this->Session->setFlash(__('Invoice deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	public function delete_employee_payment($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Employee Payment', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->data = $this->Invoice->ClientsContract->Employee->EmployeesPayment->read(null, $id);
		
		if ($this->Invoice->ClientsContract->Employee->EmployeesPayment->delete($id)) {
			$this->Session->setFlash(__('Employee Payment deleted', true));
			$this->redirect(array('action'=>'view','id'=>$this->data['Invoice']['id'] ));
		}
	}
    public function send($id = null) {
            Configure::write('debug', 2);
    		if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid Invoice', true));
				$this->redirect(array('action'=>'index'));
			}
    	
            $this->Email->template = 'email/confirm';
            // You can use customised thmls or the default ones you setup at the start
            
           	$invoice = $this->Invoice->read(null, $id);
            $this->set('invoice', $invoice);
            
			// Contract
			$contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);

			// Client
			$client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
			// Employee
			$employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);
			
			$this->Email->to = 'invoicetest@fogtest.com';
			$this->Email->toName = 'Timecards';
            // $this->Email->subject = $filename;

            $this->Email->from         = 'timecards@rocketsredglare.com';
            $this->Email->fromName     = "Rockets Redglare A/R";
            
            // $this->Email->body = $filename;
            $this->Invoice->generatepdf($invoice['Invoice']['id'], null, $this->xml_home);
			
	    $subject = $this->invoiceFunction->email_subject($invoice, $employee);
	    // $filename =  $this->invoiceFunction->invoiceFilename($invoice,$employee);
	    $fully_qualified_filename = $this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);
            // $new_name_when_attached=$filename; //optional
            // $this->Email->attach($fully_qualified_filename, $new_name_when_attached);
            // You can attach as many files as you like.
           
            // $result = $this->Email->send();
      }

    public function posted_reminder_void($id=null)
    {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }

        if (empty($this->data)) {
            $this->data = $this->Invoice->read(null, $id);
            $this->data['Invoice']['voided']   = 1;
            $this->Invoice->save($this->data);
            $this->redirect(array('action'=>'reminders_s/tab:posted'));

        }
    }
    /* called from radio buttons in reminders index */
    public function soap_void($id,$updown) {
        $this->layout = Null;
        if (!$id ) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->render('/elements/empty_soap_return');;
        }
        $this->Invoice->void($id,$updown);
        $this->render('/elements/empty_soap_return');;
    }
    /* called from radio buttons in reminders index */
    public function soap_timecard($id,$updown) {
        $this->layout = Null;
        $this->data['Invoice']['id']=$id;
        $this->data['Invoice']['timecard']=$updown;
        if ($this->Invoice->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    public function search() {
		$invoices = array();
		if(isset($this->data['Invoice']['search']))
		{
            $this->Invoice->unbindContractModelForInvoicing();
            $this->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog','ClientsManager'),),false);
            $this->Invoice->recursive = 2;
            $this->paginate['conditions'] = array('Invoice.id like "%'.$this->data['Invoice']['search'].'%"','mock' => 0,);
            $this->paginate['order'] = array('Invoice.date'=>'DESC',);
            $invoices = $this->paginate();
            $count = 0;
            foreach ($invoices as $invoice):
                $datearray = getdate(strtotime($invoice['Invoice']['date']));

                $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
                $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
                $invoices[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
                $count++;
            endforeach;
		}
		$this->page_title = 'Search Invoices';
		$this->set('invoices', $invoices);	
	}
	public function search_bynum() {
		$this->Invoice->unbindContractModelForInvoicing();
		$this->Invoice->unbindModel(array('hasMany' =>
                array('InvoicesItem','InvoicesPayment','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesTimecardReceiptLog',
                    'InvoicesPostLog','ClientsManager'),),false);
        $this->Invoice->unbindContractModelForInvoicing();
        $this->Invoice->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array(
            'ClientsManager',
        ),),false);
		$this->paginate['conditions'] = array(
   			'contract_id != 0',
			'mock' => 0,
    	);
		if(isset($this->data['Invoice']['inv_num']))
		{
			$this->data['Invoice']['id'] = $this->data['Invoice']['inv_num'];
			unset($this->data['Invoice']['inv_num']);
		}
		$this->Invoice->recursive = 2;
		$filter = $this->Search->process($this);
		$this->set('invoices', $this->paginate(null, $filter));
		
		$this->page_title = 'Search Invoices By Number';
	}

	public function edit_employee_payment($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmployeesPayment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Invoice->ClientsContract->Employee->EmployeesPayment->save($this->data)) {
				$this->Session->setFlash(__('The EmployeesPayment has been saved', true));
				$this->redirect(array('action'=>'view','id'=>$this->data['EmployeesPayment']['invoice_id']));
			} else {
				$this->Session->setFlash(__('The EmployeesPayment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Invoice->ClientsContract->Employee->EmployeesPayment->read(null, $id);
		}
	}
	public function edit($id) {

		Configure::write('debug', 2);
		if (!empty($this->data)) {
				$invoiceToSave = $this->InvoiceFunction->AdjustDatesBeforeSave($this->data); 
				$res = $this->Invoice->ClientsContract->Invoice->save_dynamic($invoiceToSave);
				// this is a fake query to force update
				$this->redirect(array('action'=>'index'));
			}
		$this->set('employees',$this->Invoice->ClientsContract->Employee->activeEmployees());	
		$this->data = $this->Invoice->getInvoiceReview($id);
		$this->page_title = 'Edit Invoice: '.$this->data['Invoice']['id'].'-'.$this->data['Client']['Client']['name'].' - '.$this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'];
	}
	public function wc()
	{
		$this->Invoice->wc_analysis();
	}
    public function fix_commissions_items()
    {
        /*
         * fix me - move to shells??
         */

        foreach($this->data as $dat)
        {
            if(isset($dat['id']))
            {;
                $savedata=array();
                $savedata['InvoicesItemsCommissionsItem']=$dat;
                $invoice_id = $dat['invoice_id'];

                $this->Invoice->InvoicesItem->InvoicesItemsCommissionsItem->save($savedata);

            }

        }


        $this->redirect(array('action'=>'view',$invoice_id));
    }
	public function beforeRender(){
        parent::BeforeRender();
		$this->set('page_title',$this->page_title);
	}

    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'edit',
                'add',
                'soap_void',
                'soap_timecard',
        ))){
            Configure::write('debug', 0);
            Configure::write('Security.level', 'medium');
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}


?>
