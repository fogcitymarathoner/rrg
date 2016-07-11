<?php

App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'Commissions');
App::import('Component', 'FixtureDirectories');

class CommissionsPaymentsController extends AppController {

	var $name = 'CommissionsPayments';
	var $helpers = array('Html', 'Form');

    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->empModel = new Employee;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;
        $this->xml_home = Configure::read('xml_home');

        parent::__construct();
    }
	function index() {
		$this->CommissionsPayment->recursive = 0;
		$this->paginate = array(
            'order' => array('CommissionsPayment.date' => 'asc'),
            'limit' => 30,
        );
		$this->set('commissionsPayments', $this->paginate('CommissionsPayment'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CommissionsPayment.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('commissionsPayment', $this->CommissionsPayment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			if ($this->data['CommissionsPayment']['cleared'] == NULL)
				$this->data['CommissionsPayment']['cleared'] = 0;

            $datea = array();
            $datea['month'] = date("m",strtotime($this->data['CommissionsPayment']['date']));
            $datea['year'] = date("Y",strtotime($this->data['CommissionsPayment']['date']));

			$this->data['CommissionsPayment']['commissions_report_id'] =
                    $this->commsComp->reportID_fromdate($datea);
			$this->data['CommissionsPayment']['commissions_reports_tag_id'] =
                $this->CommissionsReportsTag->shell_tagID($this->data['CommissionsPayment']['employee_id'],$this->data['CommissionsPayment']['commissions_report_id']);
			
			$this->CommissionsPayment->create();
			if ($this->CommissionsPayment->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsPayment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CommissionsPayment could not be saved. Please, try again.', true));
			}
		}
		$employees = $this->CommissionsPayment->Employee->find('list');
		$this->set(compact('employees'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CommissionsPayment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->data['CommissionsPayment']['cleared'] == NULL)
				$this->data['CommissionsPayment']['cleared'] = 0;


            $datea = array();
            $datea['month'] = date("m",strtotime($this->data['CommissionsPayment']['date']));
            $datea['year'] = date("Y",strtotime($this->data['CommissionsPayment']['date']));


            $this->data['CommissionsPayment']['commissions_report_id'] =
                    $this->commsComp->reportID_fromdate($datea);
			$this->data['CommissionsPayment']['commissions_reports_tag_id'] =
                $this->CommissionsReportsTag->shell_tagID($this->data['CommissionsPayment']['employee_id'],$this->data['CommissionsPayment']['commissions_report_id']);
			
			if ($this->CommissionsPayment->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsPayment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CommissionsPayment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CommissionsPayment->read(null, $id);
		}
		$employees = $this->CommissionsPayment->Employee->find('list');
		$this->set(compact('employees'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CommissionsPayment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CommissionsPayment->delete($id)) {
			$this->Session->setFlash(__('CommissionsPayment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	/* called from radio buttons in reminders index */
	function soap_void($id,$updown) {
        $this->layout = Null;
        $this->data['CommissionsPayment']['id']=$id;
        $this->data['CommissionsPayment']['voided']=$updown;
		if ($this->CommissionsPayment->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
		} else {
			;
		}
	}

	
}
?>