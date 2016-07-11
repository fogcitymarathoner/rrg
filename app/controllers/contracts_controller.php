<?php
class ContractsController extends AppController {

	var $name = 'Contracts';
	var $page_title ;
	var $uses = array('ClientsContract');

	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Contract.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->ClientsContract->recursive = 1;
		$this->data = $this->ClientsContract->read(Null,$id); //debug($this->data);exit;
		$this->page_title = $this->data['ClientsContract']['title'].' details';
		$this->layout = 'print';	
	}
	
}
?>