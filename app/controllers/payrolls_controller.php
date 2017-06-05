<?php
App::import('Component', 'Payroll');
App::import('Component', 'Json');
//require_once("XML/Serializer.php");

require_once dirname(__FILE__) . '/../XML/Serializer.php';
class PayrollsController extends AppController {
	var $name = 'Payrolls';
	var $helpers = array('Html', 'Form');
    var $paginate = array('limit' => 100, 'page' => 1, 'order'=>array('date'=>'desc'));
	var $page_title ;	
	function index() {
		$this->Payroll->recursive = 0;
		$this->set('payrolls', $this->paginate());
		$this->page_title = "Payrolls";
	}
	function select_paystubs_checks($id=null) {
        // make sure all paychecks have been recognized and an employee is not being double billed
        $this->Payroll->check_for_cleared();
		$paychecks = $this->Payroll->EmployeesPayment->Invoice->paychecks_due();
		$checkpaychecks = array();
		$ddpaychecks = array();
		$count = 0;
		foreach ($paychecks as $paycheck): 
			if($paycheck['Paycheck']['direct_deposit'] == 0)
			{
				$checkpaychecks[$count++]['Paycheck'] = $paycheck['Paycheck'];
			}
		endforeach;		
		$this->page_title = "Payroll - Checks Outstanding";
	    $this->set(compact('checkpaychecks'));	
	}
	function select_paystubs_dd($id=null) {
        // make sure all paychecks have been recognized and an employee is not being double billed
        $this->Payroll->check_for_cleared();
        $paychecks = $this->Payroll->EmployeesPayment->Invoice->paychecks_due();
		$checkpaychecks = array();
		$ddpaychecks = array();
        $count = 0;
		foreach ($paychecks as $paycheck): 
			if($paycheck['Paycheck']['direct_deposit'] != 0)
			{
				$ddpaychecks[$count++]['Paycheck'] = $paycheck['Paycheck'];
			}
		endforeach;
		$this->page_title = "Payroll - Direct Deposits Outstanding";
	    $this->set(compact('ddpaychecks'));	
	}
	function verify() { 
		if (empty($this->data)) {
			$this->Session->setFlash(__('No Timecards Selected', true));
			$this->redirect(array('controller'=>'payrolls','action'=>'index'));
		}
		if (!empty($this->data)) {
			$payrolltotal=0; 
			$paychecks = array();
			$count = 0;
			foreach ($this->data['Paycheck']['Paycheck'] as $pay): 
				$this->Payroll->EmployeesPayment->Invoice->unbindModel(array('hasMany' => 
								array('InvoicesTimecardReminderLog','InvoicesPostLog',								
								),),false);
			
				$invoice = $this->Payroll->EmployeesPayment->Invoice->find('all',array('conditions'=>array('Invoice.id'=>$pay)));
				//debug($invoice);exit;
				$empPaymentTotal = 0;
				foreach ($invoice[0]['EmployeesPayment'] as $empPayment): 
					$empPaymentTotal +=  $empPayment['amount'];
				endforeach;
				$timecardpay = 0;
				foreach ($invoice[0]['InvoicesItem'] as $paytype): 
					$timecardpay +=  round($paytype['quantity']* $paytype['cost'],2);
				endforeach;
				$balance =  $timecardpay- $empPaymentTotal ;
				if($balance > 0 )
				{
					$payrolltotal+= $balance;
						$this->Payroll->EmployeesPayment->Employee->unbindModel(array('belongsTo' => 
										array('State'),),false);
						$this->Payroll->EmployeesPayment->Employee->unbindModel(array('hasMany' => 
										array('ClientsContract','EmployeesMemo',								
										'EmployeesPayment','EmployeesEmail'),),false);
						$employee = $this->Payroll->EmployeesPayment->Employee->find('all', 
											array('conditions'=>array('Employee.id'=>$invoice[0]['ClientsContract']['employee_id'])));
					$invoice[0]['Invoice']['emp_balance']= $balance;
					$invoice[0]['Employee']= $employee[0]['Employee'];
					
					$paychecks[$count++]= $invoice[0];
				}
			endforeach;
			if($payrolltotal <= 0 )
			{//debug($this->data);exit;
				$this->Session->setFlash(__('The Payroll Total did not come to a positive number', true));
				$this->redirect(array('action'=>'index'));
			}
			//debug($paychecks);exit;
			$this->set(compact('paychecks','payrolltotal'));		
		}		
		$this->page_title = "Payroll - Verify amounts and name the payroll run";
	}
	function verified() {
		if (empty($this->data)) {
			$this->Session->setFlash(__('No timecards selected', true));
			$this->redirect(array('controller'=>'payrolls','action'=>'index'));
		}
		if (!empty($this->data)) { 
			$this->Payroll->create();
			$dateex = explode('/',$this->data['Payroll']['date']);
			$this->data['Payroll']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
            $this->data['Payroll']['securitytoken'] = $this->PasswordHelper->generatePaycheckToken();;
			//debug($this->data);exit;
			if ($this->Payroll->save($this->data)) {
				$this->Session->setFlash(__('The Payroll has been saved', true));
				$payroll_id = $this->Payroll->getLastInsertID ();
                $this->data['Payroll']['id'] = $payroll_id;
                $this->data['date_generated']=  date('D, d M Y H:i:s');
				foreach ($this->data['Payroll']['Paycheck'] as $paycheck): 
					$this->Payroll->EmployeesPayment->Invoice->unbindModel(array('hasMany' => 
								array('InvoicesTimecardReminderLog','InvoicesPostLog',								
								),),false);
					$invoice = $this->Payroll->EmployeesPayment->Invoice->find('all', array(
												'conditions'=>array('Invoice.id'=>$paycheck,
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
														'ClientsContract.employee_id'),
														)
													);
					$employee_id = $invoice[0]['ClientsContract']['employee_id'];
					$invoice_id = $invoice[0]['Invoice']['id'];
					$date = $this->data['Payroll']['date'];
					$timecardpay = 0;
					foreach ($invoice[0]['InvoicesItem'] as $paytype): 
						$timecardpay +=  round($paytype['quantity']* $paytype['cost'],2);
					endforeach;
                    $user = $this->Auth->user();
					$this->data['EmployeesPayment']['invoice_id'] = $invoice_id;
					$this->data['EmployeesPayment']['payroll_id'] = $payroll_id;
					$this->data['EmployeesPayment']['employee_id'] = $employee_id;
					$this->data['EmployeesPayment']['amount'] = $timecardpay;
                    $this->data['EmployeesPayment']['date'] = $date;
                    $this->data['EmployeesPayment']['modified_date'] = date('Y-m-d');
                    $this->data['EmployeesPayment']['created_date'] = date('Y-m-d');
                    $this->data['EmployeesPayment']['modified_user_id'] = $user['User']['id'];
                    $this->data['EmployeesPayment']['created_user_id'] = $user['User']['id'];
					$this->data['EmployeesPayment']['securitytoken'] = $this->PasswordHelper->generatePaycheckToken();
					$this->Payroll->EmployeesPayment->create();
					$this->Payroll->EmployeesPayment->save($this->data);	
					$paycheck_id = $this->Payroll->EmployeesPayment->getLastInsertID ();

					// PR AUTO CLEAR!!
					$invoice['Invoice']['prcleared'] = 1;
					$this->Payroll->EmployeesPayment->Invoice->save($invoice);


				endforeach;

                /*
                 * retrieve payroll with all associated payments
                 */
                $this->Payroll->EmployeesPayment->Employee->unbindModel(array('belongsTo' => array('State'),),false);

                $pay = $this->Payroll->find('all',array(
                    'conditions'=>array('id'=>$payroll_id),
                ));
                $pay = $this->Payroll->add_transmittal_info_to_payment($pay[0]);
                /*
                 * write modified structure to transmittal
                 */
                $this->xml_home = Configure::read('xml_home');
                $xml_home = $this->xml_home;

                App::import('Model', 'cache/payroll');

                $cache_payrollModel = new PayrollCache;

                $cache_payrollModel->cache_payroll($pay, $xml_home);
				$this->redirect(array('controller'=>'payrolls','action'=>'view/'.$this->data['EmployeesPayment']['payroll_id']));				
			} else {
				$this->Session->setFlash(__('The Paychecks could not be issued. Please, try again.', true));
				$this->redirect(array('controller'=>'payrolls','action'=>'index'));				
			}
		}
	}
	function select_check_directdeposit() {
		if (!empty($this->data)) {
			if($this->data['Payroll']['Paycheck'][0]==0)
			{
				$this->redirect(array('controller'=>'payrolls','action'=>'select_paystubs_checks'));				
			} else
			{
				$this->redirect(array('controller'=>'payrolls','action'=>'select_paystubs_dd'));				
				
			}
		}
		$keys=array(0,1);
		$names=array('Checks','DirectDeposits');
		$this->set(compact('keys','names'));			
		$this->page_title = "Payroll - Select Checks or Direct Deposits";		
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Payroll.', true));
			$this->redirect(array('action'=>'index'));
		}
        $payments = $this->Payroll->payroll_view_data($id);
        $payments = $this->Payroll->prepare_payments_for_paystub_distribution($payments);

        $payrollComp = new PayrollComponent;
        $payroll = $payrollComp->updateTotal($id);
        $user = $this->Auth->user();
        $this->set('employeesControl', $payrollComp->prefill_label_form($payroll,$user));

        $this->set('payroll', $payroll);
        $step1_script= $this->Payroll->encryption_step1_splitA_encrypt($payments);
        $step2_script= $this->Payroll->encryption_step2_email($payments);
        $this->xml_home = Configure::read('xml_home');
        $payrollComp->writeout_distribution_scripts($this->xml_home,$step1_script,$step2_script,$id);
        $this->set('step1_script', $step1_script);
        $this->set('step2_script', $step2_script);
        $this->set('xml_home', $this->xml_home);
		$this->set(compact('payments'));
		$this->page_title = "Payroll - Viewing Payroll - ".$payroll['Payroll']['name'];
	}
    function labels() {
        if (!$this->params['named']['id']) {
            $this->Session->setFlash(__('Invalid Payroll.', true));
            $this->redirect(array('action'=>'index'));
        }
        $id = $this->params['named']['id'];
        $payments = $this->Payroll->payroll_view_data($id);
        $payments = $this->Payroll->prepare_payments_for_paystub_distribution($payments);
        $this->set(compact('id'));
        $this->set(compact('payments'));
        $this->page_title = 'Select Employees For Labels';
        $payroll = $this->Payroll->read(null, $id);
        $this->set('payroll', $payroll);

        $payrollComp = new PayrollComponent;
        $payroll = $payrollComp->updateTotal($id);
        Configure::write('debug',2); // this makes the action available in routes
        $user = $this->Auth->user();
        $this->set('employeesControl', $payrollComp->prefill_label_form($payroll,$user));
    }
	function refapp($id = null) {
		if(!$this->data)
		{
			if (!$id) {
				$this->Session->setFlash(__('Invalid Payroll.', true));
				$this->redirect(array('action'=>'index'));
			}
            $payments = $this->Payroll->payments_for_refapp($id);

			$payroll = $this->Payroll->read(null, $id);

			$this->set('payroll', $payroll);
			$this->set(compact('payments'));
			$this->page_title = "Payroll - Editing Paycheck References - ".$payroll['Payroll']['name'];	
		}
		else
		{
			foreach(array_keys($this->data['EmployeesPayment'] )as $payment_id):
			
				$ref = $this->data['EmployeesPayment'][$payment_id];
				$payment = array();
				$payment['EmployeesPayment']['id'] = $payment_id;
				$payment['EmployeesPayment']['ref'] = $ref;
				$this->Payroll->EmployeesPayment->save($payment);
			endforeach;
			$this->redirect(array('action'=>'refapp',$this->data['Payrolls']['id']));
		}
	}

    function paystub_document_manager($id = null) {
        if(!$this->data)
        {
            if (!$id) {
                $this->Session->setFlash(__('Invalid Payroll.', true));
                $this->redirect(array('action'=>'index'));
            }
            $payments = $this->Payroll->payments_for_document_manager($id);

            $payroll = $this->Payroll->read(null, $id);

            $this->set('payroll', $payroll);
            $this->set(compact('payments'));
            $this->page_title = "Payroll - Put paystubs into document manager - ".$payroll['Payroll']['name'];
        }
    }
	
	function add() {
		if (!empty($this->data)) {

            $dateex = explode('/',$this->data['Payroll']['date']);
            $this->data['Payroll']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
			$this->Payroll->create();
			if ($this->Payroll->save($this->data)) {
				$this->Session->setFlash(__('The Payroll has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Payroll could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Payroll', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {

            $dateex = explode('/',$this->data['Payroll']['date']);
            $this->data['Payroll']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
			if ($this->Payroll->save($this->data)) {
				$this->Session->setFlash(__('The Payroll has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Payroll could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
            $payrollComp = new PayrollComponent;
            $payroll = $payrollComp->updateTotal($id);
			$this->data = $payroll;
		}
	}
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Payroll', true));
			$this->redirect(array('action'=>'index'));
		}
        $pr = $this->Payroll->read(null, $id);

		if ($this->Payroll->delete($id)) {
            // reset prcleared so employee can be paid
            foreach ($pr['EmployeesPayment'] as $ck)
            {
                $single = array('EmployeesPayment' => $pr);
                $inv = $this->Payroll->EmployeesPayment->Invoice->read(null, $ck['invoice_id']);
                $inv['Invoice']['prcleared'] = 0;
                $inv = $this->Payroll->EmployeesPayment->Invoice->save($inv);
            }
			$this->Session->setFlash(__('Payroll deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function edit_employeepayment($id = null) {
		if (!empty($this->data)) {//debug($this->data);exit;
			if ($this->Payroll->EmployeesPayment->save($this->data)) {
				$this->Session->setFlash(__('The EmployeesPayment has been saved', true));
				$this->redirect(array('action'=>'view',$this->data['EmployeesPayment']['payroll_id']));
			} else {
				$this->Session->setFlash(__('The EmployeesPayment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Payroll->EmployeesPayment->read(null, $id);
			$this->data['ClientsContract'] = $this->Payroll->EmployeesPayment->Invoice->ClientsContract->read(null, $this->data['Invoice']['contract_id']);
			$this->data['Client'] = $this->Payroll->EmployeesPayment->Invoice->ClientsContract->Client->read(null, $this->data['ClientsContract']['ClientsContract']['client_id']);
		}
	}
	function delete_employeepayment($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmployeesPayment', true));
			$this->redirect(array('action'=>'index'));
		}
		$payment = $this->Payroll->EmployeesPayment->read(null, $id);
		if ($this->Payroll->EmployeesPayment->delete($id)) {
			$this->Session->setFlash(__('EmployeesPayment deleted', true));
			$this->redirect(array('action'=>'view',$payment['EmployeesPayment']['payroll_id']));
		}
	}			
	function beforeRender(){		
        parent::BeforeRender();        
		$this->set('page_title',$this->page_title);
	}

    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
            'edit',
            'select_check_directdeposit',
            'select_paystubs_dd',
            'select_paystubs_checks',
            'verify',
            'verified',
        ))){
            Configure::write('debug',2);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}
?>
