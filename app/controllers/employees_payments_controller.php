<?php
class EmployeesPaymentsController extends AppController {

    var $name = 'EmployeesPayments';
    var $paginate = array(
        'limit' => 200,
        'order' => array(
            'EmployeesPayment.date' => 'desc'
        )
    );
    function index() {
        $this->EmployeesPayment->recursive = 0;
        //debug($this->paginate());exit;
        $this->set('employeesPayments', $this->paginate());
    }
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid employees payment', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('employeesPayment', $this->EmployeesPayment->read(null, $id));
    }
    function add() {
        if (!empty($this->data)) {
            $this->EmployeesPayment->create();
            if ($this->EmployeesPayment->save($this->data)) {
                $this->Session->setFlash(__('The employees payment has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The employees payment could not be saved. Please, try again.', true));
            }
        }
        $employees = $this->EmployeesPayment->Employee->find('list');
        $payrolls = $this->EmployeesPayment->Payroll->find('list');
        $invoices = $this->EmployeesPayment->Invoice->find('list');
        $this->set(compact('employees', 'payrolls', 'invoices'));
    }
    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid employees payment', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->EmployeesPayment->save($this->data)) {
                $this->Session->setFlash(__('The employees payment has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The employees payment could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->EmployeesPayment->read(null, $id);
        }
        $employees = $this->EmployeesPayment->Employee->find('list');
        $payrolls = $this->EmployeesPayment->Payroll->find('list');
        $invoices = $this->EmployeesPayment->Invoice->find('list');
        $this->set(compact('employees', 'payrolls', 'invoices'));
    }
    function x()
    {

    }
    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for employees payment', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->EmployeesPayment->delete($id)) {
            $this->Session->setFlash(__('Employees payment deleted', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Employees payment was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }
    function reorder_payments()
    {
        Configure::write('debug',0); // this makes the action available in routes
        $i = 0;
        $this->data['EmployeesPayment'] = array();
        foreach( $this->params['form']['paymenttable'] as $check):
            if($check != NULL)
            {
                $this->data['EmployeesPayment'][$i]['id'] = $check;
                $this->data['EmployeesPayment'][$i]['ordering'] = ($i+1)*10;
                $i++;
            }
        endforeach;
        $savepayment = array();
        foreach( $this->data['EmployeesPayment'] as $payment):
            $savepayment['EmployeesPayment'] = $payment;
            if ($payment['id'] != NULL)
            {
                $this->EmployeesPayment->save($savepayment);
                $this->EmployeesPayment->commit();
            }
        endforeach;
        $firstpayment = $this->EmployeesPayment->read(null,$this->data['EmployeesPayment'][0]['id']);
        $payments = $this->EmployeesPayment->Payroll->payroll_view_data($firstpayment['EmployeesPayment']['payroll_id']);
        $payments = $this->EmployeesPayment->Payroll->prepare_payments_for_paystub_distribution($payments);
        $step1_script= $this->EmployeesPayment->Payroll->encryption_step1_splitA_encrypt($payments);
        $step2_script= $this->EmployeesPayment->Payroll->encryption_step2_email($payments);
        $this->xml_home = Configure::read('xml_home');
        $payrollComp = new PayrollComponent;
        $payrollComp->writeout_distribution_scripts($this->xml_home,$step1_script,$step2_script,$firstpayment['EmployeesPayment']['payroll_id']);

        header('Content-type: application/json');
        echo '{';
        echo '}'; exit;
    }
    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'reorder_payments',
            ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }

}