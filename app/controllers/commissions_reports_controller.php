<?php
App::import('Component', 'Datasources');
App::import('Component', 'Commissions');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsPayment');
class CommissionsReportsController extends AppController {

	var $name = 'CommissionsReports';
	var $helpers = array('Html', 'Form');
    public function __construct()
    {
        $this->commsComp = new CommissionsComponent;
        $this->commPayModel = new CommissionsPayment;
        parent::__construct();
    }
	function index() {
		$this->CommissionsReport->recursive = 0;
		
		$this->set('commissionsReports', $this->commsComp->get_all_periods());
	}

    function view_report_fixture_printable($id = null) {
        $this->layout = 'print';
        return;
    }
    function view_report_tag_fixture($id = null) {
        return;
    }
	function view_report_tag($id = null) {
        $this->set('period', $this->commsComp->period_from_id($id));
		$this->set('employee', $tag['Employee']);
		$count = 0;
		$sum = 0;
		foreach($items as $item)
		{
			$items[$count]['InvoicesItemsCommissionsItem']['Invoice']=$invoice['Invoice'];
			$items[$count]['InvoicesItemsCommissionsItem']['Worker']=$invoice['ClientsContract']['Employee'];
			$count++;
			if($item['InvoicesItemsCommissionsItem']['voided'] == 0)
			{
				$sum = $sum + $item['InvoicesItemsCommissionsItem']['amount'];
			}
		}

		$this->set('items', $items);
        $this->commPayModel->unbindModel(array('belongsTo' => array('Employee',),),false);
		foreach($payments as $payment)
		{
			$sum = $sum - $payment['CommissionsPayment']['amount'];
		}
		$this->set('payments', $payments);
		$this->set('sum', $sum);
	}

	
	function add() {
		if (!empty($this->data)) {
			$this->CommissionsReport->create();
			if ($this->CommissionsReport->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReport has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CommissionsReport could not be saved. Please, try again.', true));
			}
		}
	}

	function add_report_tag($commissions_report_id = null) {
		$employees = array();
		foreach ($employeesAll as $employee):
			$employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
		endforeach;
		$this->set(compact('employees'));
		$this->set(compact('commissions_report_id'));
		$this->CommissionsReport->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','CommissionsPayment'),),false);		
		$this->data = $this->CommissionsReport->read(null, $commissions_report_id);//debug($this->data);exit;
	}

	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CommissionsReport', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CommissionsReport->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReport has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CommissionsReport could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CommissionsReport->read(null, $id);
		}
	}

	function edit_report_tag($id = null) {

		$commissionsReports = $this->CommissionsReport->find('list');
		$this->set(compact('commissionsReports'));
	}

	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CommissionsReport', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CommissionsReport->delete($id)) {
			$this->Session->setFlash(__('CommissionsReport deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function delete_report_tag_($id = null) {
		if (!$id) {
			$this->redirect(array('action'=>'index'));
		} 
		$this->CommissionsReport->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','CommissionsPayment'),),false);	
	}
/*
 * release_report
 *
 * fixme - soup_ prefix does not work
 */

    function beforeFilter(){
        parent::beforeFilter();
        if(isset($this->Security) && $this->RequestHandler->isAjax() && in_array($this->action ,array(
            'release_report'
        ))){
            Configure::write('debug', 0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }

}
?>
