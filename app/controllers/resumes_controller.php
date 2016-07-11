<?php
class ResumesController extends AppController {

	var $name = 'Resumes';
	var $helpers = array('Html', 'Form', 'Fck');
	
    var $paginate = array(
                'limit' => 30,
                'contain' => array('Resume'),
        'order'=>array('Resume.id' => 'desc'),
        'conditions'=>array('Resume.active' => 1),
		'fields'=>array('name','id','notes','phone','active','email'),
        );
        # does not work on host
	function index() {
		//$this->layout = 'default';
		$this->Resume->recursive = 1;
		if(isset($this->data['Resume']['search']))
		{
		    $filter = array("resume like '%".$this->data['Resume']['search']."%' OR name like '%".$this->data['Resume']['search']."%' OR notes like '%".$this->data['Resume']['search']."%' OR phone like '%".$this->data['Resume']['search']."%'  OR email like '%".$this->data['Resume']['search']."%'"
	        );
		} else {
			$filter = '';
		}
		$this->set('resumes', $this->paginate(null, $filter));
	}
	function component_search() {
		if (!empty($this->data)) {
		
			$this->Resume->recursive = 1;
	        $filter = $this->Search->process($this);
	        $this->set('resumes', $this->paginate(null, $filter));	
		} else 
		{
			$this->Resume->recursive = 0;
			$this->set('resumes', $this->paginate());
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Resume.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('resume', $this->Resume->read(null, $id));
	}
	
	function add() { 
		if (!empty($this->data)) {
			$this->Resume->create();
			$this->data['Resume']['created_date'] = date('Y-m-d');
			if ($this->Resume->save($this->data)) {
				$this->Session->setFlash(__('The Resume has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Resume could not be saved. Please, try again.', true));
			}
		}
		$clientsSearches = $this->Resume->ClientsSearch->find('list',array('conditions'=>array('active'=>1)));
		$this->set(compact('clientsSearches'));
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Resume', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Resume->save($this->data)) {
				$this->Session->setFlash(__('The Resume has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Resume could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Resume->read(null, $id);
		}
		$clientsSearches = $this->Resume->ClientsSearch->find('list',array('conditions'=>array('active'=>1)));
		$this->set(compact('clientsSearches'));
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Resume', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Resume->delete($id)) {
			$this->Session->setFlash(__('Resume deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	/* called from radio buttons in index list */	
	function soap_activeinactive($id,$updown)
	{
        $this->layout = Null;
        $this->data['Resume']['id']=$id;
        $this->data['Resume']['active']=$updown;
             if ($this->Resume->save($this->data)) {
                 $this->render('/elements/empty_soap_return');;
             } else {
                 ;
             }
	}
	function search() {
		if (!empty($this->data)) {
			$this->Resume->recursive = -1;
        		$filter = $this->Search->process($this);
			$this->set('resumes', $this->paginate(null, $filter));
		} else
		{
			$this->Resume->recursive = 0;
			$this->set('resumes', $this->paginate());
		}
		$states = $this->Resume->State->find('list');
		$this->set(compact('states'));
	}

    function beforeFilter(){
        parent::beforeFilter();
        $this->page_title = 'Clients Page';
        if(isset($this->Security) && $this->RequestHandler->isAjax() && in_array($this->action ,array(

        ))){
            Configure::write('debug', 0);
            $this->Security->enabled = false;
        }

        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
            'add',
            'edit',
        ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
        }
    }

}
?>