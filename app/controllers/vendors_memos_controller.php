<?php
class VendorsMemosController extends AppController {

	var $name = 'VendorsMemos';
	var $helpers = array('Html', 'Form');

        var $paginate = array(
                'limit' => 10,
                'contain' => array('VendorMemo')
                );

	function index() {
		$this->VendorsMemo->recursive = 0;
		$this->set('vendorsMemos', $this->paginate());
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VendorsMemo.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('vendorsMemo', $this->VendorsMemo->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VendorsMemo->create();
			if ($this->VendorsMemo->save($this->data)) {
				$this->Session->setFlash(__('The VendorsMemo has been saved', true));
                //debug($this->data);exit;
				$this->redirect(array('controller'=>'vendors','action'=>'view/'.$this->data['VendorsMemo']['vendor_id']));
			} else {
				$this->Session->setFlash(__('The VendorsMemo could not be saved. Please, try again.', true));
			}
		}
		$this->VendorsMemo->Vendor->unbindModel(array('hasMany' => array('VendorMemo'),),false);
		$vendor=$this->VendorsMemo->Vendor->read(null, $this->params['named']['vendor_id']);
		$this->set(compact('vendor'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VendorsMemo', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VendorsMemo->save($this->data)) {
				$this->Session->setFlash(__('The VendorsMemo has been saved', true));
                $this->redirect(array('controller'=>'vendors','action'=>'view/'.$this->data['VendorsMemo']['vendor_id']));
			} else {
				$this->Session->setFlash(__('The VendorsMemo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VendorsMemo->read(null, $id);
			$this->VendorsMemo->Vendor->unbindModel(array('hasMany' => array('VendorMemo'),),false);
			$vendor=$this->VendorsMemo->Vendor->read(null, $this->data['VendorsMemo']['vendor_id']);
			$this->layout='default_nomenu';
			
			$this->set(compact('vendor'));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VendorsMemo', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->data = $this->VendorsMemo->read(null, $id); 
		if ($this->VendorsMemo->delete($id)) {
			$this->Session->setFlash(__('VendorsMemo deleted', true));
            $this->redirect(array('controller'=>'vendors','action'=>'view/'.$this->data['VendorsMemo']['vendor_id']));
		}
	}
	}
?>