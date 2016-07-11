<?php
class VendorsCategoriesController extends AppController {

	var $name = 'VendorsCategories';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VendorsCategory->recursive = 0;
		$this->set('vendorsCategories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VendorsCategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('vendorsCategory', $this->VendorsCategory->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VendorsCategory->create();
			if ($this->VendorsCategory->save($this->data)) {
				$this->Session->setFlash(__('The VendorsCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VendorsCategory could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VendorsCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VendorsCategory->save($this->data)) {
				$this->Session->setFlash(__('The VendorsCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VendorsCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VendorsCategory->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VendorsCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VendorsCategory->delete($id)) {
			$this->Session->setFlash(__('VendorsCategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>