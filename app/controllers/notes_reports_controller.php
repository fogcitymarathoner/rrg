<?php
class NotesReportsController extends AppController {

	var $name = 'NotesReports';
	var $uses = 'CommissionsReport';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CommissionsReport->recursive = 0;
		
		$this->set('commissionsReports', $this->paginate());
	}

	

	function view($id = null) { 
		if (!$id) {
			$this->Session->setFlash(__('Invalid NotesReport.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->CommissionsReport->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','NotesPayment',),),false);
		$this->CommissionsReport->recursive=2;
		$this->set('commissionsReport', $this->CommissionsReport->read(null, $id));

		$payments = $this->CommissionsReport->NotesPayment->find('all',
					array('conditions'=>array('NotesPayment.commissions_report_id'=>$id)));

		//debug($payments);exit;
		$this->set('NotesPayment', $payments);//debug($items);exit;
	}
	function view_report_tag($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CommissionsReportsTag.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->CommissionsReport->CommissionsReportsTag->recursive = 1;
		$this->CommissionsReport->CommissionsReportsTag->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem',),),false);
		$tag = $this->CommissionsReport->CommissionsReportsTag->read(null, $id);
		$this->set('tag', $tag['CommissionsReportsTag']);
		$this->set('commissionsReport', $tag['CommissionsReport']);
		$this->set('employee', $tag['Employee']);

		$this->CommissionsReport->CommissionsReportsTag->recursive = 2;
		$this->CommissionsReport->CommissionsReportsTag->bindModel(array('hasMany' => array('InvoicesItemsCommissionsItem',),),false);
		$this->CommissionsReport->CommissionsReportsTag->bindModel(array('belongsTo' => array('Employee',),),false);
		$report = $this->CommissionsReport->find('all',array('conditions'=>array('id'=>$tag['CommissionsReportsTag']['commissions_report_id'])));
		$items = $this->CommissionsReport->CommissionsReportsTag->InvoicesItemsCommissionsItem->find('all', 
									array('conditions'=>array('commissions_reports_tag_id'=>$id),
													'order'=>array('InvoicesItemsCommissionsItem.description ASC','InvoicesItemsCommissionsItem.date ASC'))); 
		$count = 0;
		foreach($items as $item)
		{
			$this->CommissionsReport->CommissionsReportsTag->InvoicesItemsCommissionsItem->InvoicesItem->Invoice->recursive=2;
			$invoice = $this->CommissionsReport->CommissionsReportsTag->InvoicesItemsCommissionsItem->InvoicesItem->Invoice->find('first',
			    array('conditions'=>array('Invoice.id'=>$item['InvoicesItem']['invoice_id'])));
			//debug($invoice);exit;
			$items[$count]['InvoicesItemsCommissionsItem']['Invoice']=$invoice['Invoice'];
			$items[$count]['InvoicesItemsCommissionsItem']['Worker']=$invoice['ClientsContract']['Employee'];
			$count++;
		}
		//debug($items);exit;
		$this->set('items', $items);
		$this->CommissionsReport->CommissionsReportsTag->NotesPayment->unbindModel(array('belongsTo' => array('Employee',),),false);
		$payments = $this->CommissionsReport->CommissionsReportsTag->NotesPayment->find('all', 
									array('conditions'=>array('commissions_reports_tag_id'=>$id),
													'order'=>array('NotesPayment.date ASC'))); 
		//debug($payments);exit;
		$this->set('payments', $payments);
	}

	
	function add() {
		if (!empty($this->data)) {
			$this->CommissionsReport->create();
			if ($this->CommissionsReport->save($this->data)) {
				$this->Session->setFlash(__('The NotesReport has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NotesReport could not be saved. Please, try again.', true));
			}
		}
	}

	function add_report_tag($commissions_report_id = null) {
		if (!empty($this->data)) { //debug($this->data);exit;
			$this->CommissionsReport->CommissionsReportsTag->create();
			if ($this->CommissionsReport->CommissionsReportsTag->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReportsTag has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['CommissionsReportsTag']['commissions_report_id']));
			} else {
				$this->Session->setFlash(__('The CommissionsReportsTag could not be saved. Please, try again.', true));
			}
		}
		$NotesReports = $this->CommissionsReport->CommissionsReportsTag->NotesReport->find('list');
		$this->set(compact('NotesReports'));
		$this->CommissionsReport->CommissionsReportsTag->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
		$this->CommissionsReport->CommissionsReportsTag->Employee->unbindModel(array('belongsTo' => array('State'),),false);

		$employeesAll = $this->CommissionsReport->CommissionsReportsTag->Employee->find('all',array('conditions'=>array('active'=>1)));
		$employees = array();
		foreach ($employeesAll as $employee):
			$employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
		endforeach;
		$this->set(compact('employees'));
		$this->set(compact('commissions_report_id'));
		$this->CommissionsReport->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','NotesPayment'),),false);		
		$this->data = $this->CommissionsReport->read(null, $commissions_report_id);//debug($this->data);exit;
	}

	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid NotesReport', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CommissionsReport->save($this->data)) {
				$this->Session->setFlash(__('The NotesReport has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NotesReport could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CommissionsReport->read(null, $id);
		}
	}

	function edit_report_tag($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CommissionsReportsTag', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CommissionsReport->CommissionsReportsTag->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReportsTag has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['CommissionsReportsTag']['commissions_report_id']));
			} else {
				$this->Session->setFlash(__('The CommissionsReportsTag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CommissionsReport->CommissionsReportsTag->read(null, $id);
		}
		$NotesReports = $this->CommissionsReport->find('list');
		$this->set(compact('NotesReports'));
	}

	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for NotesReport', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CommissionsReport->delete($id)) {
			$this->Session->setFlash(__('NotesReport deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function delete_report_tag_($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CommissionsReportsTag', true));
			$this->redirect(array('action'=>'index'));
		} 
		$this->CommissionsReport->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','NotesPayment'),),false);	
		$this->data = $this->CommissionsReport->CommissionsReportsTag->read(null, $id);//debug($this->data);exit;
		if ($this->CommissionsReport->CommissionsReportsTag->delete($this->data['CommissionsReportsTag']['id'])) {
			$this->Session->setFlash(__('CommissionsReportsTag deleted', true));
			$this->redirect(array('action'=>'view/'.$this->data['CommissionsReportsTag']['commissions_report_id']));
		
		}
	}
	
}
?>