<?php
class InvoicesItemsCommissionsItemsController extends AppController {

	var $name = 'InvoicesItemsCommissionsItems';
	var $helpers = array('Html', 'Form');

    var $paginate = array(
            'limit' => 150,
            'contain' => array('InvoicesItemsCommissionsItem'),
   		'order'=>array('date' => 'ASC'),
    );
	function index() {
		$this->InvoicesItemsCommissionsItem->recursive = 0;
		$this->set('invoicesItemsCommissionsItems', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoicesItemsCommissionsItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoicesItemsCommissionsItem', $this->InvoicesItemsCommissionsItem->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InvoicesItemsCommissionsItem->create();
			if ($this->InvoicesItemsCommissionsItem->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesItemsCommissionsItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoicesItemsCommissionsItem could not be saved. Please, try again.', true));
			}
		}
		$employees = $this->InvoicesItemsCommissionsItem->Employee->find('list');
		$invoicesItems = $this->InvoicesItemsCommissionsItem->InvoicesItem->find('list');
		$this->set(compact('employees', 'invoicesItems'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoicesItemsCommissionsItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoicesItemsCommissionsItem->save($this->data)) {
				$this->Session->setFlash(__('The InvoicesItemsCommissionsItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoicesItemsCommissionsItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoicesItemsCommissionsItem->read(null, $id);
		}
		$employees = $this->InvoicesItemsCommissionsItem->Employee->find('list');
		$invoicesItems = $this->InvoicesItemsCommissionsItem->InvoicesItem->find('list');
		$this->set(compact('employees','invoicesItems'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InvoicesItemsCommissionsItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InvoicesItemsCommissionsItem->delete($id)) {
			$this->Session->setFlash(__('InvoicesItemsCommissionsItem deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	/* called from radio buttons in reminders index */
	function soap_void($id,$updown) {
        $this->layout = Null;
        $this->data['InvoicesItemsCommissionsItem']['id']=$id;
        $this->data['InvoicesItemsCommissionsItem']['voided']=$updown;
		if ($this->InvoicesItemsCommissionsItem->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
		} else {
			;
		}
	}

}
?>