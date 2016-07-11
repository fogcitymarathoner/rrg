<?php
class CommissionsReportsTagsController extends AppController {
#
# tag sales persons with commissions items
#
	var $name = 'CommissionsReportsTags';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CommissionsReportsTag->recursive = 0;
		$this->set('commissionsReportsTags', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CommissionsReportsTag.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('commissionsReportsTag', $this->CommissionsReportsTag->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CommissionsReportsTag->create();
			if ($this->CommissionsReportsTag->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReportsTag has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CommissionsReportsTag could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CommissionsReportsTag', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CommissionsReportsTag->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReportsTag has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CommissionsReportsTag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CommissionsReportsTag->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CommissionsReportsTag', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CommissionsReportsTag->delete($id)) {
			$this->Session->setFlash(__('CommissionsReportsTag deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>