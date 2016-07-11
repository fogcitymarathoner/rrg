<?php
class VendorsController extends AppController {

	var $name = 'Vendors';
	var $helpers = array('Html', 'Form');

    var $paginate = array(
                'limit' => 100,
                'contain' => array('Vendor'),
        		'order'=>array('Vendor.id' => 'desc'),
                );
	function index() {
		$this->Vendor->recursive = 0;
		$this->set('vendors', $this->paginate());
	}

    function m_index() {
        $this->layout = "default_jqmobile";
        if (!empty($this->data)) {

            $filter = array();
            $this->Vendor->unbindModel(array('hasMany' => array('VendorsMemo'),),false);
            $this->Vendor->unbindModel(array('belongsTo' => array('State'),),false);
            if($this->data['name']!='' && $this->data['purpose']=='' )
            {

                $vendors = $this->Vendor->find('all', array('conditions'=>array(
                    'Vendor.name LIKE'=>'%'.$this->data['name'].'%'
                )));
            } else if ($this->data['name']=='' && $this->data['purpose']!='' )
            {
                $vendors = $this->Vendor->find('all', array('conditions'=>array(
                    'Vendor.purpose LIKE'=>'%'.$this->data['purpose'].'%'
                )));

            } else if ($this->data['name']!='' && $this->data['purpose']!='' )
            {

                $filter ['Vendor.name LIKE'] = '%'.$this->data['name'].'%';
                $filter ['Vendor.purpose LIKE'] = '%'.$this->data['purpose'].'%';
                $vendors = $this->Vendor->find('all', array('conditions'=>array(
                    'Vendor.name LIKE'=>'%'.$this->data['name'].'%',
                    'Vendor.purpose LIKE'=>'%'.$this->data['purpose'].'%'
                )));
            }
            $this->Vendor->recursive = -1;
            $this->set('vendors', $vendors);
        } else
        {
            $this->Vendor->recursive = 0;
            $this->set('vendors', $this->paginate());
        }

        $this->set('page_title', 'Search Vendors');
    }


    function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Vendor.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('vendor', $this->Vendor->read(null, $id));
	}

    function m_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Vendor.', true));
            $this->redirect(array('action'=>'index'));
        }

        $encryptedVendor = $this->Vendor->read(null, $id);
        $this->data = $this->Vendor->decrypt($encryptedVendor);

        $state = $this->Vendor->State->read(null, $this->data['Vendor']['state_id']);
        $this->set('state', $state);
        $this->layout = "default_jqmobile_partial";
        $this->set('page_title', $this->data['Vendor']['name']);
    }

    function add() {
		if (!empty($this->data)) {
			$this->data['Vendor']['modified_date'] = date('Y-m-d H:m:s');
			$this->data['Vendor']['created_date'] = date('Y-m-d H:m:s');
			$this->Vendor->create();
			if ($this->Vendor->save($this->data)) {
				$this->Session->setFlash(__('The Vendor has been saved', true));
				
				$this->redirect(array('action'=>'view','id'=>$this->Vendor->getLastInsertID ()));
			} else {
				$this->Session->setFlash(__('The Vendor could not be saved. Please, try again.', true));
				
			}
		}
		$states = $this->Vendor->State->find('list');
		$this->set(compact('states'));
	}

    function m_add() {
        //debug($this->data);exit;
        if (!empty($this->data)) {

            $this->data['Vendor']['modified_date'] = date('Y-m-d H:m:s');
            $this->data['Vendor']['created_date'] = date('Y-m-d H:m:s');

            $this->Vendor->create();
            if ($this->Vendor->save($this->data)) {
                $this->Session->setFlash(__('The Vendor has been saved', true));

                $this->redirect(array('prefix'=>'m','action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Vendor could not be saved. Please, try again.', true));
            }
        }
        $states = $this->Vendor->State->find('list');
        $this->set(compact('states'));
        $this->layout = "default_jqmobile_partial";
        $this->set('page_title', 'Add New Vendor');
    }

    function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Vendor', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Vendor']['modified_date'] = date('Y-m-d H:m:s');
			if ($this->Vendor->save($this->data)) {
				$this->Session->setFlash(__('The Vendor has been saved', true));
				$this->redirect(array('action'=>'view','id'=>$this->data['Vendor']['id']));
			} else {
				$this->Session->setFlash(__('The Vendor could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Vendor->read(null, $id);
		}
		$this->layout='default_nomenu';
		$states = $this->Vendor->State->find('list');
		$this->set(compact('states'));
	}

    function m_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Vendor', true));
            $this->redirect(array('action'=>'index'));
        }
        //debug($this->data);exit;
        if (!empty($this->data)) {

            $this->data['Vendor']['modified_date'] = date('Y-m-d H:m:s');
            if ($this->Vendor->save($this->data)) {
                $this->Session->setFlash(__('The Vendor has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Vendor could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $encryptedVendor = $this->Vendor->read(null, $id);
            $this->data = $this->Vendor->decrypt($encryptedVendor);
        }
        $states = $this->Vendor->State->find('list');
        $this->set(compact('states'));
        $this->layout = "default_jqmobile_partial";
        $this->set('page_title', $this->data['Vendor']['name']);
    }
	function activate($id = null) {
			$this->data['Vendor']['modified_date'] = date('Y-m-d H:m:s');
			$this->data['Vendor']['state_id'] = 2;
			if ($this->Vendor->save($this->data)) {
				$this->Session->setFlash(__('The Vendor has been activated', true));
				$this->redirect(array('action'=>'index','tab'=>'lastmod'));
			} else {
				$this->Session->setFlash(__('The Vendor could not be activated. Please, try again.', true));
			}
	}
	function deactivate($id = null) {
			$this->data['Vendor']['modified_date'] = date('Y-m-d H:m:s');
			$this->data['Vendor']['state_id'] = 1;
			if ($this->Vendor->save($this->data)) {
				$this->Session->setFlash(__('The Vendor has been deactivated', true));
				$this->redirect(array('action'=>'index','tab'=>'lastmod'));
			} else {
				$this->Session->setFlash(__('The Vendor could not be deactivated. Please, try again.', true));
			}
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Vendor', true));
			$this->redirect(array('action'=>'index','tab'=>'lastmod'));
		}
		if ($this->Vendor->delete($id)) {
			$this->Session->setFlash(__('Vendor deleted', true));
			$this->redirect(array('action'=>'index','tab'=>'lastmod'));
		}
	}
    function m_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Vendor', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Vendor->delete($id)) {
            $this->Session->setFlash(__('Vendor deleted', true));
            $this->redirect(array('prefix'=>'m','action'=>'index'));
        }
    }
	function search() {
		if (!empty($this->data)) {
            $filter = array();
            if($this->data['Vendor']['name']!='' && $this->data['Vendor']['purpose']=='' )
            {
                $filter ['Vendor.name LIKE'] = '%'.$this->data['Vendor']['name'].'%';
            } else if ($this->data['Vendor']['name']=='' && $this->data['Vendor']['purpose']!='' )
            {
                $filter ['Vendor.purpose LIKE'] = '%'.$this->data['Vendor']['purpose'].'%';

            } else if ($this->data['Vendor']['name']!='' && $this->data['Vendor']['purpose']!='' )
            {

                $filter ['Vendor.name LIKE'] = '%'.$this->data['Vendor']['name'].'%';
                $filter ['Vendor.purpose LIKE'] = '%'.$this->data['Vendor']['purpose'].'%';
            }
			$this->Vendor->recursive = -1;
			$this->set('vendors', $this->paginate(null, $filter));
		} else
		{
			$this->Vendor->recursive = 0;
			$this->set('vendors', $this->paginate());
		}
	}
    public function beforeFilter(){
        parent::beforeFilter();
        $this->page_title = "Vendor's Page";
        if(isset($this->Security) && $this->RequestHandler->isAjax() && in_array($this->action ,array(
            ))){
            Configure::write('debug', 0);
            $this->Security->enabled = false;
        }

        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'm_index',
            ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
        }
    }

}
?>