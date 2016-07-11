<?php
class InvoicesPostLogsController extends AppController {

	var $name = 'InvoicesPostLogs';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->InvoicesPostLog->recursive = 0;
		$this->set('invoicesPostLogs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoicesPostLog.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoicesPostLog', $this->InvoicesPostLog->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InvoicesPostLog->create();
			if ($this->InvoicesPostLog->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesPostLog has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoicesPostLog could not be saved. Please, try again.', true));
			}
		}
		$invoices = $this->InvoicesPostLog->Invoice->find('list');
		$this->set(compact('invoices'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoicesPostLog', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoicesPostLog->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesPostLog has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoicesPostLog could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesPostLog->read(null, $id);
		}
		$invoices = $this->InvoicesPostLog->Invoice->find('list');
		$this->set(compact('invoices'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InvoicesPostLog', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InvoicesPostLog->delete($id)) {
			$this->Session->setFlash(__('InvoicesPostLog deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>