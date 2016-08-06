<?php
App::import('Component', 'Datasources');
App::import('Component', 'Commissions');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsReportsTag');
App::import('Model', 'CommissionsPayment');
class CommissionsReportsController extends AppController {

	var $name = 'CommissionsReports';
	var $helpers = array('Html', 'Form');
    public function __construct()
    {
        $this->commsComp = new CommissionsComponent;
        $this->commPayModel = new CommissionsPayment;
        $this->commRptTagModel = new CommissionsReportsTag;
        parent::__construct();
    }
	function index() {
		$this->CommissionsReport->recursive = 0;
		
		$this->set('commissionsReports', $this->commsComp->get_all_periods());
	}
	function view($id = null) { 
		if (!$id) {
			$this->Session->setFlash(__('Invalid CommissionsReport.', true));
			$this->redirect(array('action'=>'index'));
		}
        $commissionsReport = $this->commsComp->period_from_id($id);
		$this->set('commissionsReport', $commissionsReport);

		$payments = $this->commPayModel->find('all',
					array('conditions'=>array('CommissionsPayment.commissions_report_id'=>$id)));

        $this->set('commissionsPayment', $payments);//debug($items);exit;
        $this->set('tags', $this->commRptTagModel->find('all',
            array('conditions'=>array('CommissionsReportsTag.commissions_report_id'=>$id))));//debug($items);exit;
	}

    private function setup_fixture_view($filename, $id)
    {

        $dsComp = new DatasourcesComponent;

        $doc = new DOMDocument('1.0');
        $doc->load($filename);

        $root = $doc->getElementsByTagName('commissions_report');
        $emp_id = $root->item(0)->getAttribute('employee_id');
        $tag_id = $root->item(0)->getAttribute('commissions_report_id');
        $tagModel = new CommissionsReportsTag();
        $tags = $tagModel->find('all',array('conditions'=>array(
            'employee_id'=>$emp_id,
            'commissions_report_id' => $tag_id,
        )));

        $citems = $doc->getElementsByTagName('commissions_item');
        $xitems = array();
        $xitems['InvoicesItemsCommissionsItem'] = array();
        foreach($citems as $ct)
        {
            $comm_id = $ct->nodeValue;
            $filename = $dsComp->inv_comm_item_filename($comm_id);
            // skip empty file
            if(filesize($filename))
            {

                $doc2 = new DOMDocument('1.0');
                $doc2->load($filename);
                $xi = array();
                $xi['invoice_id'] = $doc2->getElementsByTagName('invoice_id')->item(0)->nodeValue;
                $filename = $dsComp->invoice_filename($xi['invoice_id']);
                $doc3 = new DOMDocument('1.0');
                $doc3->load($filename);
                $xi['period'] = date('m/d/Y',strtotime($doc3->getElementsByTagName('period_start')->item(0)->nodeValue)).' - '.
                    date('m/d/Y',strtotime($doc3->getElementsByTagName('period_end')->item(0)->nodeValue));
                $xi['description'] = $doc2->getElementsByTagName('description')->item(0)->nodeValue;
                $xi['date'] = $doc2->getElementsByTagName('date')->item(0)->nodeValue;
                $xi['percent'] = $doc2->getElementsByTagName('percent')->item(0)->nodeValue;
                $xi['amount'] = $doc2->getElementsByTagName('amount')->item(0)->nodeValue;
                $xi['rel_inv_amt'] = $doc2->getElementsByTagName('rel_inv_amt')->item(0)->nodeValue;
                $xi['rel_inv_line_item_amt'] = $doc2->getElementsByTagName('rel_inv_line_item_amt')->item(0)->nodeValue;
                $xi['rel_item_amt'] = $doc2->getElementsByTagName('rel_item_amt')->item(0)->nodeValue;
                $xi['rel_item_quantity'] = $doc2->getElementsByTagName('rel_item_quantity')->item(0)->nodeValue;
                $xi['rel_item_cost'] = $doc2->getElementsByTagName('rel_item_cost')->item(0)->nodeValue;
                $xi['cleared'] = $doc2->getElementsByTagName('cleared')->item(0)->nodeValue;
                $xi['voided'] = $doc2->getElementsByTagName('voided')->item(0)->nodeValue;
                if(!$xi['voided'])
                    $xitems['InvoicesItemsCommissionsItem'][] = $xi;
            }
        }
        //debug($xitems);

        $employee['Employee'] = $tags[0]['Employee'];
        $this->set('commItems',$xitems);
        $this->set('report_id',$id);
        $this->set('employee',$employee);
        $citems = $doc->getElementsByTagName('commissions_payment');
        $xitems = array();
        $xitems['CommissionsPayment'] = array();

        foreach($citems as $ct)
        {
            $pay_id = $ct->nodeValue;
            $filename = $dsComp->comm_payment_filename($pay_id);

            $doc2 = new DOMDocument('1.0');
            $doc2->load($filename);
            $xi = array();

            $xi['note_id'] = $doc2->getElementsByTagName('note_id')->item(0)->nodeValue;
            $xi['check_number'] = $doc2->getElementsByTagName('check_number')->item(0)->nodeValue;
            $xi['commissions_report_id'] = $doc2->getElementsByTagName('commissions_report_id')->item(0)->nodeValue;
            $xi['commissions_reports_tag_id'] = $doc2->getElementsByTagName('commissions_reports_tag_id')->item(0)->nodeValue;
            $xi['description'] = $doc2->getElementsByTagName('description')->item(0)->nodeValue;
            $xi['date'] = $doc2->getElementsByTagName('date')->item(0)->nodeValue;
            $xi['amount'] = $doc2->getElementsByTagName('amount')->item(0)->nodeValue;
            $xi['cleared'] = $doc2->getElementsByTagName('cleared')->item(0)->nodeValue;
            $xi['voided'] = $doc2->getElementsByTagName('voided')->item(0)->nodeValue;
            if(!$xi['voided'])
                $xitems['CommissionsPayment'][] = $xi;
        }

        //debug($xitems);

        $this->set('commPayments', $xitems);
    }

    function view_report_fixture_printable($id = null) {
        $this->layout = 'print';
        $commrptModel = new CommissionsReportsTag();

        if (!$id) {
            $this->Session->setFlash(__('Invalid CommissionsReport.', true));
            $this->redirect(array('action'=>'index'));
        }

        $reportDB = $this->CommissionsReport->CommissionsReportsTag->read(null,$id);
        if (!$reportDB['CommissionsReportsTag']['release']) {
            $this->Session->setFlash(__('That report has not been released.', true));
            $this->redirect(array('action'=>'index'));
        }

        $this->setup_fixture_view($commrptModel->get_hash_filename($id), $id);
        return;
    }
    function view_report_tag_fixture($id = null) {
        $commrptModel = new CommissionsReportsTag();

        if (!$id) {
            $this->Session->setFlash(__('Invalid CommissionsReport.', true));
            $this->redirect(array('action'=>'index'));
        }

        $reportDB = $this->CommissionsReport->CommissionsReportsTag->read(null,$id);
        if (!$reportDB['CommissionsReportsTag']['release']) {
            $this->Session->setFlash(__('That report has not been released.', true));
            $this->redirect(array('action'=>'index'));
        }

        $this->setup_fixture_view($commrptModel->get_hash_filename($id), $id);
        return;
    }
	function view_report_tag($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CommissionsReportsTag.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->CommissionsReport->CommissionsReportsTag->recursive = 1;
		$this->CommissionsReport->CommissionsReportsTag->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem',),),false);
		$tag = $this->CommissionsReport->CommissionsReportsTag->read(null, $id);
        $this->set('period', $this->commsComp->period_from_id($id));

		$this->set('tag', $tag['CommissionsReportsTag']);

		$this->set('employee', $tag['Employee']);

		$this->CommissionsReport->CommissionsReportsTag->recursive = 2;
		$this->CommissionsReport->CommissionsReportsTag->bindModel(
			array('hasMany' => array('InvoicesItemsCommissionsItem',),),false);
		$this->CommissionsReport->CommissionsReportsTag->bindModel(array('belongsTo' => array('Employee',),),false);

		$items = $this->CommissionsReport->CommissionsReportsTag->InvoicesItemsCommissionsItem->find('all',
			array('conditions'=>array('commissions_reports_tag_id'=>$id),
				'order'=>array('InvoicesItemsCommissionsItem.date ASC')));
		$count = 0;
		$sum = 0;
		foreach($items as $item)
		{
			$this->CommissionsReport->CommissionsReportsTag->InvoicesItemsCommissionsItem->
				InvoicesItem->Invoice->recursive=2;
			$invoice = $this->CommissionsReport->CommissionsReportsTag->InvoicesItemsCommissionsItem->
				InvoicesItem->Invoice->find('first',
			    array('conditions'=>array('Invoice.id'=>$item['InvoicesItem']['invoice_id'])));

			$items[$count]['InvoicesItemsCommissionsItem']['Invoice']=$invoice['Invoice'];
			$items[$count]['InvoicesItemsCommissionsItem']['Worker']=$invoice['ClientsContract']['Employee'];
			$count++;
			$sum = $sum + $item['InvoicesItemsCommissionsItem']['amount'];
		}

		$this->set('items', $items);
        $this->commPayModel->unbindModel(array('belongsTo' => array('Employee',),),false);
		$payments = $this->commPayModel->find('all',
									array('conditions'=>array('CommissionsPayment.commissions_reports_tag_id'=>$id),
													'order'=>array('CommissionsPayment.date ASC')));
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
		if (!empty($this->data)) { //debug($this->data);exit;
			$this->CommissionsReport->CommissionsReportsTag->create();
			if ($this->CommissionsReport->CommissionsReportsTag->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReportsTag has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['CommissionsReportsTag']['commissions_report_id']));
			} else {
				$this->Session->setFlash(__('The CommissionsReportsTag could not be saved. Please, try again.', true));
			}
		}
		$commissionsReports = $this->CommissionsReport->CommissionsReportsTag->CommissionsReport->find('list');
		$this->set(compact('commissionsReports'));
		$this->CommissionsReport->CommissionsReportsTag->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
		$this->CommissionsReport->CommissionsReportsTag->Employee->unbindModel(array('belongsTo' => array('State'),),false);

		$employeesAll = $this->CommissionsReport->CommissionsReportsTag->Employee->find('all',array('conditions'=>array('active'=>1)));
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
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CommissionsReportsTag', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CommissionsReport->CommissionsReportsTag->save($this->data)) {
				$this->Session->setFlash(__('The CommissionsReportsTag has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['CommissionsReportsTag']['commissions_report_id']));
			} else {
				$this->Session->setFlash(__('The CommissionsReportsTag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CommissionsReport->CommissionsReportsTag->read(null, $id);
		}
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
			$this->Session->setFlash(__('Invalid id for CommissionsReportsTag', true));
			$this->redirect(array('action'=>'index'));
		} 
		$this->CommissionsReport->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','CommissionsPayment'),),false);	
		$this->data = $this->CommissionsReport->CommissionsReportsTag->read(null, $id);//debug($this->data);exit;
		if ($this->CommissionsReport->CommissionsReportsTag->delete($this->data['CommissionsReportsTag']['id'])) {
			$this->Session->setFlash(__('CommissionsReportsTag deleted', true));
			$this->redirect(array('action'=>'view/'.$this->data['CommissionsReportsTag']['commissions_report_id']));
		
		}
	}
/*
 * release_report
 *
 * fixme - soup_ prefix does not work
 */
    function release_report() {
        Configure::write('debug', 2);
        $report_tag_id = $this->params['form']['tag'];
        $value = $this->params['form']['value'];
        $report_tag = $this->CommissionsReport->CommissionsReportsTag->cache_tag($report_tag_id);
        echo '{}';
        exit;
    }

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
