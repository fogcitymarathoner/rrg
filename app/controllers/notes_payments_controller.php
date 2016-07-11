<?php
class NotesPaymentsController extends AppController {

	var $name = 'NotesPayments';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->NotesPayment->recursive = 0;
		$this->set('notesPayments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid NotesPayment.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('notesPayment', $this->NotesPayment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->NotesPayment->create();
			if ($this->NotesPayment->save($this->data)) {
				$this->Session->setFlash(__('The NotesPayment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NotesPayment could not be saved. Please, try again.', true));
			}
		}
		$employees = $this->NotesPayment->Employee->find('list');
		//$notesReports = $this->NotesPayment->CommissionsReport->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid NotesPayment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->NotesPayment->save($this->data)) {
				$this->Session->setFlash(__('The NotesPayment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NotesPayment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NotesPayment->read(null, $id);
		}
		$employees = $this->NotesPayment->Employee->find('list');
		//$notesReports = $this->NotesPayment->CommissionsReport->find('list');
		$this->set(compact('employees');
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for NotesPayment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->NotesPayment->delete($id)) {
			$this->Session->setFlash(__('NotesPayment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>