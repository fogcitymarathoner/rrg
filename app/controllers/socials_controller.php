<?php
class SocialsController  extends AppController {

	var $name = 'Socials';
	
	var $uses = array('Employee');
    function from_slug($slug = null,$api_key = null) {
		$this->Invoice->recursive = 2;
		$API='b0569824b20f8583e9a2084aa4d925660ec3b1b5';
		if (!$slug) {
			$this->Session->setFlash(__('Invalid Employee.', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!$api_key || $api_key != $API ) {
			$this->Session->setFlash(__('Invalid api.', true));
			$this->redirect(array('action'=>'index'));
		}
		$employee = $this->Employee->find('first', array('conditions'=>array('slug'=>$slug)));
		$employee = $this->Employee->decrypt(&$employee); 
		
		$this->layout = 'print';	
		$this->set(compact('employee'));
		
	}

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allowedActions = array('*', );
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
            'from_slug',
        ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
        }
    }
}
