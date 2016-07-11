<?php
class InvoicesTimecardReminderLogsController extends AppController {

	var $name = 'InvoicesTimecardReminderLogs';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->InvoicesTimecardReminderLog->recursive = 0;
		$this->set('invoicesTimecardReminderLogs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoicesTimecardReminderLog.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoicesTimecardReminderLog', $this->InvoicesTimecardReminderLog->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InvoicesTimecardReminderLog->create();
			if ($this->InvoicesTimecardReminderLog->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesTimecardReminderLog has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoicesTimecardReminderLog could not be saved. Please, try again.', true));
			}
		}
		$invoices = $this->InvoicesTimecardReminderLog->Invoice->find('list');
		$this->set(compact('invoices'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoicesTimecardReminderLog', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoicesTimecardReminderLog->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesTimecardReminderLog has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoicesTimecardReminderLog could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesTimecardReminderLog->read(null, $id);
		}
		$invoices = $this->InvoicesTimecardReminderLog->Invoice->find('list');
		$this->set(compact('invoices'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InvoicesTimecardReminderLog', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InvoicesTimecardReminderLog->delete($id)) {
			$this->Session->setFlash(__('InvoicesTimecardReminderLog deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>