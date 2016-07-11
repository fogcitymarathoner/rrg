<?php
class InvoicesOpeningsController extends AppController {

	var $name = 'InvoicesOpenings';

	function index() {
		$this->InvoicesOpening->recursive = 0;
		$this->set('invoicesOpenings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid invoices opening', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('invoicesOpening', $this->InvoicesOpening->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InvoicesOpening->create();
			if ($this->InvoicesOpening->save($this->data)) {
				$this->Session->setFlash(__('The invoices opening has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invoices opening could not be saved. Please, try again.', true));
			}
		}
		$employees = $this->InvoicesOpening->Employee->find('list');
		$invoices = $this->InvoicesOpening->Invoice->find('list');
		$this->set(compact('employees', 'invoices'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid invoices opening', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoicesOpening->save($this->data)) {
				$this->Session->setFlash(__('The invoices opening has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invoices opening could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesOpening->read(null, $id);
		}
		$employees = $this->InvoicesOpening->Employee->find('list');
		$invoices = $this->InvoicesOpening->Invoice->find('list');
		$this->set(compact('employees', 'invoices'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for invoices opening', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InvoicesOpening->delete($id)) {
			$this->Session->setFlash(__('Invoices opening deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Invoices opening was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
