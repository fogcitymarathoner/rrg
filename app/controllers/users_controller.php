<?php
class UsersController extends AppController {

	var $name = 'Users';

    var $paginate = array(
                'limit' => 30,
                'contain' => array('Users')
    );
	function index() {
		$this->User->recursive = 0;
        	$filter = $this->Search->process($this);
        	$this->set('users', $this->paginate(null, $filter));
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$user = $this->User->read(null, $id);
		$this->set('user', $user);
	}


	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}
	function change_password($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Password has been changed.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->data = $this->User->read(null, $id);
				$this->Session->setFlash(__('Password could not be changed. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	function search() {
	// Setup dropdowns in search action/view

	}
    function new_user_session()
    {
        $this->Auth->login();

        $this->redirect(array('controller' => 'reminders', 'action' => 'index', 'home'));
    }

    function m_new_user_session()
    {
        $this->Auth->login();
        if ($this->Auth->user()) {
            $this->redirect($this->Auth->redirect());
        }

    }
	/**
	* The AuthComponent provides the needed functionality
	* for login, so you can leave this function blank.
	*/
	function login() {
		$page = 'Please sign in.';
		$this->set(compact('page'));	
		$this->layout='users/login';
	}
    function m_login() {
        $page = 'Please sign in.';
        $this->set(compact('page'));
        $this->layout='users/login';
    }
    function soap_login() {
        $page = 'Please sign in.';
        $this->set(compact('page'));
        $this->layout='users/login';
    }
	function logout() {
	    $this->redirect($this->Auth->logout());
	}
    function beforeFilter() {
        $this->Auth->allowedActions = array('login','new_user_session','m_new_user_session' );

        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'edit',
            ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}
?>
