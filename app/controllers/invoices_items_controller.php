<?php
class InvoicesItemsController extends AppController {

	var $name = 'InvoicesItems';
	var $helpers = array('Html', 'Form');

        var $paginate = array(
                'limit' => 200,
                'contain' => array('InvoicesItems')
                );

	function index() {
		$this->InvoicesItem->recursive = 0;
		$this->set('invoicesItems', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoicesItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoicesItem', $this->InvoicesItem->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) { 
			$item = $this->InvoicesItem->Invoice->ClientsContract->ContractsItem->read(null, $this->data['InvoicesItem']['contracts_items_id']);
			$commissionsitems = $this->InvoicesItem->Invoice->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->find('all', array('conditions' =>array('contracts_items_id'=>$this->data['InvoicesItem']['contracts_items_id'])));
			$this->data['InvoicesItem']['invoice_id']=$this->data['InvoicesItem']['invoice_id'];
			$this->data['InvoicesItem']['amount']=$item['ContractsItem']['amt'];
			$this->data['InvoicesItem']['cost']=$item['ContractsItem']['cost'];
			$this->data['InvoicesItem']['amount']=$item['ContractsItem']['amt'];
			$this->data['InvoicesItem']['description']=$item['ContractsItem']['description'];
			$this->InvoicesItem->create();
			if ($this->InvoicesItem->save($this->data)) {
				$invoiceitemID = $this->InvoicesItem->getLastInsertID(); 
				foreach ($commissionsitems as $commissionsitem):
					$items = array();
					$items['InvoicesItemsCommissionsItem']['employee_id']=$commissionsitem['ContractsItemsCommissionsItem']['employee_id'];
					$items['InvoicesItemsCommissionsItem']['invoices_item_id']=$invoiceitemID;
					$items['InvoicesItemsCommissionsItem']['percent']=$commissionsitem['ContractsItemsCommissionsItem']['percent'];
					$this->InvoicesItem->InvoicesItemsCommissionsItem->create();
					$this->InvoicesItem->InvoicesItemsCommissionsItem->save($items);
				endforeach;			
				$this->Session->setFlash(__('The InvoicesItem has been saved', true));
			} else {
				$this->Session->setFlash(__('The InvoicesItem could not be saved. Please, try again.', true));
			}
			$this->redirect(array('controller'=>'invoices','action'=>'view','id'=>$this->data['InvoicesItem']['invoice_id']));
		}
		$invoice = $this->InvoicesItem->Invoice->find('all',array('conditions'=> array('Invoice.id'=>$this->params['named']['invoice_id'])));
		$contractItems = $this->InvoicesItem->Invoice->ClientsContract->ContractsItem->find('all',array('conditions'=>array('contract_id'=>$invoice[0]['ClientsContract']['id'])));
		$items = array();
		foreach ($contractItems as $contractItem):
			$items[$contractItem['ContractsItem']['id']] = $contractItem['ContractsItem']['description'].':$'.$contractItem['ContractsItem']['amt'];
		endforeach;
		$this->set(compact('items','contractItems'));
	}

	function edit($id = null) {
		$this->InvoicesItem->recursive = 0;
		$crumbs = $this->Session->read('crumb_links');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoicesItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoicesItem->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesItem has been saved', true));
				
				$this->redirect($crumbs[0]);
			} else {
				$this->Session->setFlash(__('The InvoicesItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesItem->read(null, $id);
		}
	}
	function timecard_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoicesItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoicesItem->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesItem has been saved', true));
				$this->redirect(array('controller'=> 'invoices','action'=>'timecard_view/'.$this->data['InvoicesItem']['invoice_id']));
			} else {
				$this->Session->setFlash(__('The InvoicesItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesItem->read(null, $id);
		}
		$invoices = $this->InvoicesItem->Invoice->find('list');
		$this->set(compact('invoices'));
	}
	function timecard_add() {
		if (!empty($this->data)) { 
			$item = $this->InvoicesItem->Invoice->ClientsContract->ContractsItem->read(null, $this->data['InvoicesItem']['contracts_items_id']);
			$commissionsitems = $this->InvoicesItem->Invoice->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->find('all', array('conditions' =>array('contracts_items_id'=>$this->data['InvoicesItem']['contracts_items_id'])));
			$this->data['InvoicesItem']['invoice_id']=$this->data['InvoicesItem']['invoice_id'];
			$this->data['InvoicesItem']['amount']=$item['ContractsItem']['amt'];
			$this->data['InvoicesItem']['cost']=$item['ContractsItem']['cost'];
			$this->data['InvoicesItem']['amount']=$item['ContractsItem']['amt'];
			$this->data['InvoicesItem']['description']=$item['ContractsItem']['description'];
			$this->InvoicesItem->create();
			if ($this->InvoicesItem->save($this->data)) {
				$invoiceitemID = $this->InvoicesItem->getLastInsertID(); 
				foreach ($commissionsitems as $commissionsitem):
					$items = array();
					$items['InvoicesItemsCommissionsItem']['employee_id']=$commissionsitem['ContractsItemsCommissionsItem']['employee_id'];
					$items['InvoicesItemsCommissionsItem']['invoices_item_id']=$invoiceitemID;
					$items['InvoicesItemsCommissionsItem']['percent']=$commissionsitem['ContractsItemsCommissionsItem']['percent'];
					$this->InvoicesItem->InvoicesItemsCommissionsItem->create();
					$this->InvoicesItem->InvoicesItemsCommissionsItem->save($items);
				endforeach;			
				$this->Session->setFlash(__('The InvoicesItem has been saved', true));
			} else {
				$this->Session->setFlash(__('The InvoicesItem could not be saved. Please, try again.', true));
			}
			$this->redirect(array('controller'=>'invoices','action'=>'timecard_view','id'=>$this->data['InvoicesItem']['invoice_id']));
		}
		$invoice = $this->InvoicesItem->Invoice->find('all',array('conditions'=> array('Invoice.id'=>$this->params['named']['invoice_id'])));
		$contractItems = $this->InvoicesItem->Invoice->ClientsContract->ContractsItem->find('all',array('conditions'=>array('contract_id'=>$invoice[0]['ClientsContract']['id'])));
		$items = array();
		foreach ($contractItems as $contractItem):
			$items[$contractItem['ContractsItem']['id']] = $contractItem['ContractsItem']['description'].':$'.$contractItem['ContractsItem']['amt'];
		endforeach;
		$this->set(compact('items','contractItems'));
	}
	function timecard_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InvoicesItem', true));
			$this->redirect(array('action'=>'index'));
		}
		$item = $this->InvoicesItem->read(null, $id);
		
		if ($this->InvoicesItem->delete($id)) {
			$this->Session->setFlash(__('InvoicesItem deleted', true));
			$this->redirect(array('controller'=>'invoices', 'action'=>'timecard_view','id'=>$item['InvoicesItem']['invoice_id']));
		}
	}
	
}
?>