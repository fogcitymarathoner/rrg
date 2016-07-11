<?php
class ProfilesController extends AppController {

	var $name = 'Profiles';

	function index() {
		$this->Profile->recursive = 0;
		$this->set('profiles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid profile', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('profile', $this->Profile->read(null, $id));
	}

    function activeEmployees()
   	{
   		$i = 0;
   		$employeesdb = $this->Profile->Employee->find('all',array('conditions'=>array('active'=>1)));
   		$employees= array();
   		foreach ($employeesdb as $employee):
   			$employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
   		endforeach;
   		return $employees;
   	}
	function add() {
        Configure::write('debug',2);
		if (!empty($this->data)) {
			$this->Profile->create();
			if ($this->Profile->save($this->data)) {
                debug(' saved');exit;
				$this->Session->setFlash(__('The profile has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
                debug('not saved');exit;
				$this->Session->setFlash(__('The profile could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Profile->User->find('list');
        $employees = $this->activeEmployees();
		$this->set(compact('users', 'employees'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid profile', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Profile->save($this->data)) {
				$this->Session->setFlash(__('The profile has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The profile could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Profile->read(null, $id);
		}
		$users = $this->Profile->User->find('list');
        $employees = $this->activeEmployees();
		$this->set(compact('users', 'employees'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for profile', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Profile->delete($id)) {
			$this->Session->setFlash(__('Profile deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Profile was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    function beforeFilter(){
        parent::beforeFilter();
        $this->page_title = 'Profiles Page';
        if(isset($this->Security) && $this->RequestHandler->isAjax() && in_array($this->action ,array(

        ))){
            Configure::write('debug', 0);
            $this->Security->enabled = false;
        }

        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
            'add',
        ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
        }
    }

}
