<?php
class InvoicesPaymentsController extends AppController {

	var $name = 'InvoicesPayments';
	var $helpers = array('Html', 'Form');

        var $paginate = array(
                'limit' => 10,
                'contain' => array('InvoicesPayment')
                );

	function index() {
		$this->InvoicesPayment->recursive = 0;
		$this->set('invoicesPayments', $this->paginate());
	}

	function reorder_payments()
	{
		//$handle = fopen("/tmp/log.txt", "w+");
		//$x =  print_r ($this->params['form']['checktable'],TRUE);
		$i = 0;
		$this->data['InvoicesPayments'] = array();
		foreach( $this->params['form']['checktable'] as $check):
			$this->data['InvoicesPayments'][$i]['id'] = $check;
			$this->data['InvoicesPayments'][$i]['ordering'] = ($i+1)*10;
			$i++;
		endforeach;
		$savepayment = array();
		foreach( $this->data['InvoicesPayments'] as $payment):
			$savepayment['InvoicesPayment'] = $payment;
			//$z = print_r ($savepayment,TRUE);
			if ($payment['id'] != NULL)
				$this->InvoicesPayment->save($savepayment);
				//fwrite($handle,$z) ;
			//fwrite($handle,$z) ;
		endforeach;
	}
	function view($id = null) {
		$this->Invoice->recursive = 1;
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoicesPayment.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoicesPayment', $this->InvoicesPayment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InvoicesPayment->create();
			if ($this->InvoicesPayment->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesPayment has been saved', true));
				$this->redirect(array('controller'=>'invoices','action'=>'view','id'=>$this->data['InvoicesPayment']['invoice_id']));
			} else {
				$this->Session->setFlash(__('The InvoicesPayment could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$crumbs = $this->Session->read('crumb_links'); 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoicesPayment', true));
			$this->redirect($crumbs[0]);
		}
		if (!empty($this->data)) {
			$invoice_id = $this->data['InvoicesPayment']['invoice_id'];			
			if ($this->InvoicesPayment->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesPayment has been saved', true));
				$this->InvoicesPayment->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
				$invoice =  $this->InvoicesPayment->Invoice->read(null, $invoice_id);
				$paymentTotal = 0;
				foreach ($invoice['InvoicesPayment'] as $payment):
					$paymentTotal += $payment['amount'];
				endforeach;					
				$balance = $invoice['Invoice']['amount']-$paymentTotal;
				if ($balance != 0)
				{
					$invoice['Invoice']['cleared']= 0;
					$this->InvoicesPayment->Invoice->save($invoice);
				} else {
                    $invoice['Invoice']['cleared']= 1;
                    $invoice['Invoice']['cleared_date']= date('Y-m-d');
					$this->InvoicesPayment->Invoice->save($invoice);					
				}				
				$this->redirect($crumbs[0]);
			} else {
				$this->Session->setFlash(__('The InvoicesPayment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesPayment->read(null, $id);
		}
	}

	function delete($id = null) {
		$crumbs = $this->Session->read('crumb_links'); 
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InvoicesPayment', true));
			$this->redirect($crumbs[0]);
		}
		$payment = $this->InvoicesPayment->read(null, $id);
		$invoice_id = $payment['InvoicesPayment']['invoice_id'];	
		if ($this->InvoicesPayment->delete($id)) {
			//debug($payment);exit;
			$this->Session->setFlash(__('InvoicesPayment deleted', true));
				$this->InvoicesPayment->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
				$invoice =  $this->InvoicesPayment->Invoice->read(null, $invoice_id);
				$paymentTotal = 0;
				foreach ($invoice['InvoicesPayment'] as $payment):
					$paymentTotal += $payment['amount'];
				endforeach;					
				$balance = $invoice['Invoice']['amount']-$paymentTotal;
				if ($balance != 0)
				{
					$invoice['Invoice']['cleared']= 0;
					$this->InvoicesPayment->Invoice->save($invoice);
				} else {
					$invoice['Invoice']['cleared']= 1;
                    $invoice['Invoice']['cleared_date']= date('Y-m-d');
					$this->InvoicesPayment->Invoice->save($invoice);					
				}			
			$this->redirect($crumbs[0]);
		}
	}

}
?>