<?php

App::import('Component', 'Xml');

class EmployeesController extends AppController {

    var $name = 'Employees';
    var $page_title ;
    var $uses = array('Employee','CommissionsPayment', 'InvoicesItemsCommissionsItem',
        'CommissionsPayment', 'Note', 'NotesPayment', 'CommissionsReportsTag');
    var $helpers = array('Html', 'Form');
    var $paginate = array(
        'limit' => 48,
        'contain' => array('Employee'),
        'order'=>array('date' => 'desc'),
    );
    public function __construct() {
        parent::__construct();

        $this->xmlComp = new XmlComponent;
    }
    private function setup_employee_payments($employee)
    {
        $count = 0;

        foreach($employee['Paychecks'] as $payment)
        {
            $employee['Payments'][$count]['Paycheck']['invoice_id'] = $payment['Paycheck']['Invoice']['id'];
            $employee['Payments'][$count]['Paycheck']['period_start'] = $payment['Paycheck']['Invoice']['period_start'];
            $employee['Payments'][$count]['Paycheck']['period_end'] = $payment['Paycheck']['Invoice']['period_end'];
            $employee['Payments'][$count]['Paycheck']['date'] = $payment['Paycheck']['Invoice']['date'];
            $employee['Payments'][$count]['Paycheck']['notes'] = $payment['Paycheck']['Invoice']['notes'];
            $employee['Payments'][$count]['Paycheck']['amountdue'] = $payment['Paycheck']['amountdue'];
            $employee['Payments'][$count]['Paycheck']['InvoicesItem']=$payment['Paycheck']['InvoicesItem'];
            $employee['Payments'][$count]['Paycheck']['payroll_id']=$payment['Paycheck']['payroll_id'];
            $employee['Payments'][$count]['Paycheck']['display'] = $payment['Paycheck']['prcleared'];
            $count ++;
        }
        return $employee;
    }

    private function non_mobile_jqbeforesave()
    {
        /*
         * a little preprocesing before editing invoice
         */
        $this->data['Employee']['firstname']= strtoupper ( $this->data['Employee']['firstname']);
        $this->data['Employee']['lastname']= strtoupper ( $this->data['Employee']['lastname']);
        $this->data['Employee']['street1']= strtoupper ( $this->data['Employee']['street1']);
        $this->data['Employee']['street2']= strtoupper ( $this->data['Employee']['street2']);
        $this->data['Employee']['city']= strtoupper ( $this->data['Employee']['city']);

        $date_array = explode('/',$this->data['Employee']['startdate']);
        $this->data['Employee']['startdate'] = $date_array[2].'-'.$date_array[0].'-'.$date_array[1];
        if (isset($this->data['Employee']['enddate']))
        {
            $date_array = explode('/',$this->data['Employee']['enddate']);
            $this->data['Employee']['enddate'] = $date_array[2].'-'.$date_array[0].'-'.$date_array[1];
        }
        $date_array = explode('/',$this->data['Employee']['dob']);
        $this->data['Employee']['dob'] = $date_array[2].'-'.$date_array[0].'-'.$date_array[1];


        if (isset( $this->data['Employee']['email']) &&  $this->data['Employee']['email'] != null) {
            $username =  $this->data['Employee']['email'];
            $username_count = $this->Employee->find('count',array('conditions'=>array('username like "'.$username.'%"','Employee.id !='.$this->data['Employee']['id'])));
            $this->data['Employee']['username'] = $username;
        }
    }

    private function directLaborCost($id = null) {
        $this->Employee->ClientsContract->Invoice->recursive = 1;
        $invoice = $this->Employee->ClientsContract->Invoice->read(null, $id);
        $DLR = 0;
        foreach ($invoice['InvoicesItem'] as $invoiceItem):
            $DLR += $invoiceItem['quantity']*$invoiceItem['cost'];
        endforeach;
        return ($DLR);
    }

    private function redirectFromContractsItem($data)
    {
        //$clientsContract = $this->Employee->ClientsContract->clientcontract_mock_invoice_manage($data['ContractsItem']['contract_id']);
        $next = $data['ContractsItem']['next'];
        if( $next == 'view_mock_invoice' || $next == 'view_contract_items')
        {
            $this->redirect(array('action'=>$data['ContractsItem']['next'], $data['ContractsItem']['contract_id']));
        }
    }
    public function index() {

        $this->Employee->recursive = 1;
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract',
            'EmployeesMemo','EmployeesPayment','CommissionsReportsTag','CommissionsPayment',
            'NotesPayment','Note','InvoicesItemsCommissionsItem','Expense','EmployeesLetter'),),false);
        $this->paginate['conditions'] = array(
            'Employee.active'=>1,
            'Employee.voided'=>0,
        );
        $this->paginate['order'] = array(
            'Employee.startdate ASC',
        );
        $employees = $this->paginate();
        $this->set('employees', $employees);

        $jsonComp = new JsonComponent;
        $this->set('employeesControl', $jsonComp->employees_json($employees));
        $this->page_title = 'Employees';
    }
    public function active_document_management() {
        $this->Employee->recursive = 1;
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract',
            'EmployeesMemo','EmployeesPayment','CommissionsReportsTag','CommissionsPayment',
            'NotesPayment','Note','InvoicesItemsCommissionsItem','Expense','EmployeesLetter'),),false);
        $this->paginate['conditions'] = array(
            'Employee.active'=>1,
            'Employee.voided'=>0,
        );
        $this->paginate['order'] = array(
            'Employee.startdate ASC',
        );
        $employees = $this->paginate();
        $this->set('employees', $employees);
        $jsonComp = new JsonComponent;
        $this->set('employeesControl', $jsonComp->employees_json($employees));
        $this->page_title = 'Employees';
    }
    public function incomplete() {
        /*
         * present list of employee whose paperwork is still in progress
         */
        $this->Employee->recursive = 1;
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract',
            'EmployeesMemo','EmployeesPayment','CommissionsReportsTag','CommissionsPayment',
            'NotesPayment','Note','InvoicesItemsCommissionsItem','Expense','EmployeesLetter'),),false);
        $this->paginate['conditions'] = array(
            'Employee.active'=>1,
            'Employee.voided'=>0,
        );
        $this->paginate['order'] = array(
            'Employee.startdate ASC',
        );
        $employees = $this->paginate();
        $this->set('employees', $employees);
        $jsonComp = new JsonComponent;
        $this->set('employeesControl', $jsonComp->employees_json($employees));
        $this->page_title = 'Employees';
    }
    public function inactive() {
        /*
         * present a list of inactive employees
         */
        $this->Employee->recursive = 1;
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract',
            'EmployeesMemo','EmployeesPayment','CommissionsReportsTag','CommissionsPayment',
            'NotesPayment','Note','InvoicesItemsCommissionsItem','Expense','EmployeesLetter'),),false);
        $this->paginate['conditions'] = array(
            'Employee.active'=>0,
            'Employee.voided'=>0,
        );
        $this->paginate['order'] = array(
            'Employee.startdate ASC',
        );
        $employees = $this->paginate();
        $this->set('employees', $employees);
        $jsonComp = new JsonComponent;
        $this->set('employeesControl', $jsonComp->employees_json($employees));
        $this->page_title = 'Employees';
    }
    public function voided() {
        /*
         * present list of voided employees
         */
        $this->Employee->recursive = 1;
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract',
            'EmployeesMemo','EmployeesPayment','CommissionsReportsTag','CommissionsPayment',
            'NotesPayment','Note','InvoicesItemsCommissionsItem','Expense','EmployeesLetter'),),false);
        $this->paginate['conditions'] = array(
            'Employee.voided'=>1,
        );
        $this->paginate['order'] = array(
            'Employee.startdate ASC',
        );
        $employees = $this->paginate();
        $this->set('employees', $employees);
        $this->set('completelist', $this->Employee->completeList());
        $this->page_title = 'Voided Employees';
    }

    public function sync_sphene() {
        /*
         * setup a form to manually enter all employees document keys
         */
        $this->Employee->recursive = 1;
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract',
            'EmployeesMemo','EmployeesPayment','CommissionsReportsTag','CommissionsPayment',
            'NotesPayment','Note','InvoicesItemsCommissionsItem','Expense','EmployeesLetter'),),false);
        $this->paginate['conditions'] = array(
            'Employee.active'=>1,
            'Employee.voided'=>0,
        );
        $this->paginate['order'] = array(
            'Employee.firstname ASC',
            'Employee.lastname ASC',
        );
        $employees = $this->paginate();
        $this->set('employees', $employees);
        $this->set('completelist', $this->Employee->completeList());
        $this->page_title = 'Employees';
    }

    public function sync_sphene_step2() {
        /*
         * the post action for entering all keys at once
         */
        foreach($this->data['Employee']['Employee'] as $profile)
        {
            $profileSav['Profile']=$profile;
            $profileSav['Profile']['id'] = $profileSav['Profile']['profile_id'];

            $this->Employee->Profile->save($profileSav);
        }

        $this->redirect(array('controller'=>'employees','action'=>'sync_sphene'));
    }
    public function m_index() {
        $this->layout = "default_jqmobile";

        if (!empty($this->data)) {
            if($this->data['name']!=''  )
            {
                $employees = $this->Employee->query ('select emp.firstname, emp.lastname, emp.street1, emp.street2, '.
                    'emp.id, emp.city, emp.zip, '.
                    ' st.post_ab '.
                    ' from employees as emp '.
                    ' left join states as st on emp.state_id=st.id '.
                    ' where firstname like "%'.$this->data['name'].'%" or lastname like "%'.$this->data['name'].'%"'.
                    ' and voided = 0 '.
                    ' order by emp.firstname ASC, emp.lastname ASC');


                $this->set('employees', $employees);
            }
        } else
        {
            $employees = $this->Employee->query ('select emp.firstname, emp.lastname, emp.street1, emp.street2, '.
                'emp.id, emp.city, emp.zip, '.
                ' st.post_ab '.
                ' from employees as emp '.
                ' left join states as st on emp.state_id=st.id '.
                ' where active = 1 and voided=0'.
                ' order by emp.firstname ASC, emp.lastname ASC');
            $this->set('employees', $employees);
            $this->set('completelist', $this->Employee->completeList());
        }
        $this->page_title = 'Employees';
    }
    public function select_labels_all() {
        $this->Employee->recursive = 0;
        $employees = $this->Employee->find('all', array(
            'fields'=>array('id','firstname','lastname','phone',
                'tcard','w4','de34','i9','medical','indust','info'),
            'conditions'=>array('active'=>1,'voided'=>0)
        ));
        $this->set(compact('employees'));
        $this->page_title = 'Select Employees';
        $this->render('/employees/select_labels');
    }
    public function process_selection()
    {
        /*
         * used for label sheets, somehow
         */
        $this->Employee->recursive = 0;
        if (empty($this->data)) {
            $this->Session->setFlash(__('No employees selected', true));
            $this->redirect(array('controller'=>'employees','action'=>'select_labels'));
        }
        if (!empty($this->data)) {
            $employees = array();
            foreach ($this->data['Employee']['Employee'] as $employee):
                $resultEmployee = $this->Employee->read(null, $employee);
                array_push($employees,$resultEmployee);
            endforeach;
            $this->set(compact('employees'));
            $fixfile=$this->TokenHelper->generatePassword(8).'.json';
            $this->set(compact('fixfile'));
            $user = $this->Auth->user();
            $this->set(compact('user'));
        }
    }
    // fixme: this is duplicated in models/cache/employee.php import does not work
    function collate_employee_data_for_serialization($employee){

            {
                $emp_array = array('id' => $employee['Employee']['id'],
                    'name' => $employee['Employee']['firstname'].' '. $employee['Employee']['lastname']);
                if($employee['Employee']['active'] == 1 )
                {
                    $actives['employees'][] = $emp_array;
                } else {
                    $inactives['employees'][] = $emp_array;;
                }
                $emails = array();
                if(!empty($employee['EmployeesEmail']))
                {
                    foreach($employee['EmployeesEmail'] as $empemail)
                    {
                        $emails[]= $empemail['email'];
                    }
                }
                $employeesJS['employees'][$employee['Employee']['id']] = array('id'=>$employee['Employee']['id'],'first'=>$employee['Employee']['firstname'],'last'=>$employee['Employee']['lastname'],'active'=>$employee['Employee']['active'],'emails'=>$emails);
                $ClientsContract =$employee['ClientsContract'];
                $EmployeesLetter =$employee['EmployeesLetter'];
                $EmployeesMemo = $employee['EmployeesMemo'];
                $EmployeesPayment =$employee['EmployeesPayment'];
                $EmployeesEmail =$employee['EmployeesEmail'];
                $CommissionsReportsTag =$employee['CommissionsReportsTag'];
                $CommissionsPayment =$employee['CommissionsPayment'] ;
                $NotesPayment =$employee['NotesPayment'];
                $Note =$employee['Note'] ;
                $Expense =$employee['Expense'];
                $InvoicesItemsCommissionsItem =$employee['InvoicesItemsCommissionsItem'];
                $employee['ClientsContract'] = array();
                $employee['EmployeesLetter'] = array();
                $employee['EmployeesMemo'] = array();
                $employee['EmployeesPayment'] = array();
                $employee['EmployeesEmail'] = array();
                $employee['CommissionsReportsTag'] = array();
                $employee['CommissionsPayment'] = array();
                $employee['NotesPayment'] = array();
                $employee['Note'] = array();
                $employee['Expense'] = array();
                $employee['InvoicesItemsCommissionsItem'] = array();
                if(!empty($ClientsContract){
                    foreach($ClientsContract as $contract)
                    {
                        $employee['ClientsContract'][] = $contract['id'];
                    }
                }
                if(!empty($EmployeesLetter){
                    foreach($EmployeesLetter as $letter)
                    {
                        $employee['EmployeesLetter'][] = $letter['id'];
                    }
                }
                if(!empty($EmployeesMemo){
                    foreach($EmployeesMemo as $memo)
                    {
                        $employee['EmployeesMemo'][] = $memo['id'];
                    }
                }
                if(!empty($EmployeesPayment){
                    foreach($EmployeesPayment as $pay)
                    {
                        $employee['EmployeesPayment'][] = $pay['id'];
                    }
                }
                if(!empty($EmployeesEmail){
                    foreach($EmployeesEmail as $email)
                    {
                        $employee['EmployeesEmail'][] = $email['id'];
                    }
                }
                if(!empty($CommissionsReportsTag){
                    foreach($CommissionsReportsTag as $rtag)
                    {
                        $employee['CommissionsReportsTag'][] = $rtag['id'];
                    }
                }
                if(!empty($CommissionsPayment){
                    foreach($CommissionsPayment as $pay)
                    {
                        $employee['CommissionsPayment'][] = $pay['id'];
                    }
                }
                if(!empty($NotesPayment){
                    foreach($NotesPayment as $pay)
                    {
                        $employee['NotesPayment'][] = $pay['id'];
                    }
                }
                if(!empty($Note){
                    foreach($Note as $pay)
                    {
                        $employee['Note'][] = $pay['id'];
                    }
                }
                if(!empty($Expense){
                    foreach($Expense as $pay)
                    {
                        $employee['Expense'][] = $pay['id'];
                    }
                }
                if(!empty($InvoicesItemsCommissionsItem){
                    foreach($InvoicesItemsCommissionsItem as $pay)
                    {
                        $employee['InvoicesItemsCommissionsItem'][] = $pay['id'];
                    }
                }
                $employee['date_generated'] = date('D, d M Y H:i:s');
            }
        return $employee;
    }
    public function soap_python_view($id = null) {
        $this->layout = Null;
        Configure::write('debug', 2);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $encryptedEmployee = $this->Employee->read(null, $id);
        if($encryptedEmployee != null){
            $decryptedEmployee = $this->Employee->decrypt($encryptedEmployee);
            $this->set('payload',  $this->xmlComp->serialize_employee($this->collate_employee_data_for_serialization($decryptedEmployee)));
        } else {
            $this->set('payload',  array());
        }
    }

    public function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee = $this->Employee->view_data( $id);
        $employee = $this->Employee->decrypt($employee);
        $employee['Employee']['strikecount'] =$this->Employee->strikecount( $id);
        $employee['Employee']['ssn_crypto'] = "XXX-XX-" . substr($employee['Employee']['ssn_crypto'],-4,4);
        $employee['Employee']['bankaccountnumber'] = "XXXXXXXX" . substr($employee['Employee']['bankaccountnumber_crypto'],-4,4);
        $employee['Employee']['bankroutingnumber'] = "XXXXXXXX" . substr($employee['Employee']['bankroutingnumber_crypto'],-4,4);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' General Info';
        $this->set(compact('empemails'));
    }
    public function m_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid employee.', true));
            $this->redirect(array('action'=>'m_index'));
        }
        $encryptedEmployee = $this->Employee->read(null, $id);
        $this->data = $this->Employee->decrypt($encryptedEmployee);
        $emails = $this->Employee->EmployeesEmail->find('all',array('conditions'=>array('employee_id'=>$id)));
        $state = $this->Employee->State->read(null, $this->data['Employee']['state_id']);
        $this->set('state', $state);
        $this->layout = "default_jqmobile_partial";
        $this->set('page_title', $this->data['Employee']['firstname'].' '.$this->data['Employee']['lastname']);
        $type='view';
        $this->set(compact('type','emails'));
    }
    public function view_expense($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Expense.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('expense', $this->Employee->Expense->read(null, $id));
    }
    public function view_expenses($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_data_expenses( $id);
        //debug($employee);exit;
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Expenses';
    }
    public function view_contracts($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        //debug($this->Employee->view_data( $id));exit;
        $employee =$this->Employee->view_contract_data( $id);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Contracts';
    }

    public function view_letters($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        //debug($this->Employee->view_data( $id));exit;
        $employee =$this->Employee->view_data( $id);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Letters';
    }
    public function view_memos($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_memo_data( $id);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Memos';
        $next = 'view_active_contracts';
        $this->set(compact('next'));
    }
    public function view_paychecks_due($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_data_paychecks_due( $id);
        $count = 0;
        foreach($employee['Paychecks'] as $payment)
        {
            if ($payment['Paycheck']['prcleared'] == 0)
            {
                $payments = $this->Employee->EmployeesPayment->find('all',
                    array('conditions'=>
                        array('invoice_id'=>$payment['Paycheck']['invoice_id'])
                    ));
                $employee['Paychecks'][$count]['Paycheck']['Payments']=$payments;
                $employee['Paychecks'][$count]['Paycheck']['display'] = 1;
            } else {
                $employee['Paychecks'][$count]['Paycheck']['display'] = 0;
            }
            $count ++;
        }
        //debug($employee);exit;
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Paychecks Due';
        $next = 'view_paychecks_due/'.$employee['Employee']['id'];
        $this->set(compact('next'));
    }

    public function m_view_paychecks_due($id = null) {
        $this->layout = "default_jqmobile";
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_data_paychecks_due( $id);
        $count = 0;
        foreach($employee['Paychecks'] as $payment)
        {
            if ($payment['Paycheck']['prcleared'] == 0)
            {
                $payments = $this->Employee->EmployeesPayment->find('all',
                    array('conditions'=>
                        array('invoice_id'=>$payment['Paycheck']['invoice_id'])
                    ));
                $employee['Paychecks'][$count]['Paycheck']['Payments']=$payments;
                $employee['Paychecks'][$count]['Paycheck']['display'] = 1;
            } else {
                $employee['Paychecks'][$count]['Paycheck']['display'] = 0;
            }
            $count ++;
        }
        //debug($employee);exit;
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Paychecks Due';
        $next = 'view_paychecks_due/'.$employee['Employee']['id'];
        $this->set(compact('next'));
    }
    public function view_paychecks_due_printable($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_data_paychecks_due( $id);
        $count = 0;
        foreach($employee['Paychecks'] as $payment)
        {
            if ($payment['Paycheck']['prcleared'] == 0)
            {
                $payments = $this->Employee->EmployeesPayment->find('all',
                    array('conditions'=>
                        array('invoice_id'=>$payment['Paycheck']['invoice_id'])
                    ));
                $employee['Paychecks'][$count]['Paycheck']['Payments']=$payments;
                $employee['Paychecks'][$count]['Paycheck']['display'] = 1;
            } else {
                $employee['Paychecks'][$count]['Paycheck']['display'] = 0;
            }
            $count ++;
        }

        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Paychecks Due';
        $next = 'view_paychecks_due/'.$employee['Employee']['id'];
        $this->set(compact('next'));

        $this->layout='print';
    }
    public function view_payments($id = null) {

        Configure::write('debug',0);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee_data = $this->Employee->view_paymentdata($id);
        //debug($employee_data);exit;
        $employee =$this->Employee->view_data_paychecks_paid( $id, $employee_data);
        $employee = $this->setup_employee_payments($employee);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Payments';
        $next = 'view_payments';
        $this->set(compact('next'));
    }
    public function view_payments_print($id = null) {

        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        Configure::write('debug',0);
        $employee_data = $this->Employee->view_paymentdata($id);
        $employee =$this->Employee->view_data_paychecks_paid( $id, $employee_data);
        $employee = $this->setup_employee_payments($employee);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Payment History';

        $this->layout='print';
        $next = 'view_payments';
        $this->set(compact('next'));
    }
    public function view_skipped_timecards($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_data_skipped_timecards( $id);
        $count = 0;
        foreach($employee['Paychecks'] as $payment)
        {
            $employee['Payments'][$count]['Paycheck']['invoice_id'] = $payment['Paycheck']['Invoice']['id'];
            $employee['Payments'][$count]['Paycheck']['period_start'] = $payment['Paycheck']['Invoice']['period_start'];
            $employee['Payments'][$count]['Paycheck']['period_end'] = $payment['Paycheck']['Invoice']['period_end'];
            $employee['Payments'][$count]['Paycheck']['date'] = $payment['Paycheck']['Invoice']['date'];
            $employee['Payments'][$count]['Paycheck']['notes'] = $payment['Paycheck']['Invoice']['notes'];
            $employee['Payments'][$count]['Paycheck']['InvoicesItem']=$payment['Paycheck']['InvoicesItem'];
            $employee['Payments'][$count]['Paycheck']['display'] = 1;
            $count ++;
        }
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Skipped Timecards';
        $next = 'view_payments';
        $this->set(compact('next'));
    }
    public function view_commissions_payments($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_data( $id);
        $payments = $this->Employee->CommissionsPayment->find('all',array('conditions'=>
            array('CommissionsPayment.employee_id'=>$id),
            'order'=>'CommissionsPayment.date desc',
        )); //debug($notes);exit;
        $this->set('payments', $payments);
        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Commissions Payments';
    }

    public function view_notes_payments($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_notespayment_data( $id);

        $notes_payments = $this->Employee->NotesPayment->find('all',array('conditions'=>
            array('NotesPayment.employee_id'=>$id),
            'order'=>'NotesPayment.date desc',
        )); //debug($notes_payments);exit;
        $this->set('employee', $employee);
        $this->set('notes_payments', $notes_payments);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Notes Payments';
    }

    public function view_notes($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee =$this->Employee->view_notes_data( $id);
        $notes = $this->Employee->Note->find('all',array('conditions'=>
            array('Note.employee_id'=>$id),
            'order'=>'Note.date desc',
        )); //debug($notes);exit;
        $this->set('employee', $employee);
        $this->set('notes', $notes);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Notes';
    }

    public function view_notes_tagged_report($id = null) {
        $this->InvoicesItemsCommissionsItem->recursive = 2;
        $this->InvoicesItemsCommissionsItem->unbindModel(array('belongsTo' => array('Employee','CommissionsReport'),),false);
        $this->InvoicesItemsCommissionsItem->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem','CommissionsPayment'),),false);

        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee','CommissionsReport'),),false);
        $this->CommissionsPayment->unbindModel(array('hasMany' =>
            array('InvoicesItemsCommissionsItem','CommissionsPayment','Note'),),false);
        $tag = $this->Employee->CommissionsReportsTag->read(NULL,$id);
        $employee['Employee'] = $tag['Employee'];
        $notes = $this->Note->
            find('all',array('conditions'=>array('Note.commissions_reports_tag_id'=>$id,'Note.voided'=>0),
                'order'=>'Note.date ASC'
            ));
        $notesPayments = $this->NotesPayment->
            find('all',array('conditions'=>array('commissions_reports_tag_id'=>$id,'NotesPayment.voided'=>0),
                'order'=>'NotesPayment.date ASC'
            ));
        $this->set('notes',$notes);
        $this->set('notePayments',$notesPayments);
        $employee['Employee']['issalesforce'] = $this->Employee->issalesforce($employee['Employee']['id']);
        $this->set('employee',$employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Commissions Report';
    }
    private function setup_view_commissions_tagged_report($id = null) {
        $tag = $this->Employee->CommissionsReportsTag->read(NULL,$id);
        $employee['Employee'] = $tag['Employee'];
        $invoiceModel = new InvoiceCache;
        $commItems = $this->InvoicesItemsCommissionsItem->
            find('all',array('conditions'=>array('InvoicesItemsCommissionsItem.commissions_reports_tag_id'=>$id,'InvoicesItemsCommissionsItem.voided'=>0),
                'order'=>'date ASC'
            ));
        $i =0;
        foreach ($commItems as $item):
            $inv = $invoiceModel->read(null,$item['InvoicesItem']['invoice_id']);
            $commItems[$i++]['InvoicesItem']['Invoice'] = $inv['Invoice'];
        endforeach;

        /*  THIS IS BROKEN, voided=0 breaks it
                  $commPayments = $this->CommissionsPayment->
                          find('all',array('conditions'=>array('CommissionsPayment.commissions_reports_tag_id'=>$id,'CommissionsPayment.voided'=>0),
                                          'order'=>'CommissionsPayment.date ASC'
                          ));
                          */
        $commPaymentsbeforevoidscreen = $this->CommissionsPayment->
            find('all',array('conditions'=>array('CommissionsPayment.commissions_reports_tag_id'=>$id),
                'order'=>'CommissionsPayment.date ASC'
            ));

        $i =0;
        $commPaymentsaftervoidscreen = array();
        foreach ($commPaymentsbeforevoidscreen as $pay):
            if($pay['CommissionsPayment']['voided']==0)
            {
                $commPaymentsaftervoidscreen[$i]['CommissionsPayment'] = $pay['CommissionsPayment'];
                $commPaymentsaftervoidscreen[$i++]['CommissionsPayment']['Note'] = $pay['Note'];
            }
        endforeach;
        $commPayments = $commPaymentsaftervoidscreen;
        //debug($commPaymentsbeforevoidscreen);debug($commPaymentsaftervoidscreen);exit;
        $this->set('commItems',$commItems);
        $this->set('commPayments',$commPayments);
        $this->set('prevbal',20);
        $employee['Employee']['issalesforce'] = $this->Employee->issalesforce($employee['Employee']['id']);
        $this->set('employee',$employee);
        $this->set('report_id',$id);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Commissions Report';
    }
    public function view_commissions_tagged_report($id = null) {
        $this->setup_view_commissions_tagged_report($id);
    }


    private function setup_view_commissions_xmltagged_report($id = null) {
        $hu = new HashUtilsComponent;

        $dsComp = new DatasourcesComponent;

        $doc = new DOMDocument('1.0');
        if (file_exists($hu->employee_commissions_report_hash_filename($id)))
        {
            $doc->load($hu->employee_commissions_report_hash_filename($id));

            $root = $doc->getElementsByTagName('commissions_report');
            $emp_id = $root->item(0)->getAttribute('employee_id');
            $tag_id = $root->item(0)->getAttribute('commissions_report_id');
            $tags = $this->Employee->CommissionsReportsTag->find('all',array('conditions'=>array(
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
        } else {

            $this->set('filedoesnotexist', False);
            echo "cannot open file".$hu->employee_commissions_report_hash_filename($id)."\n";
        }
        return;
    }
    public function view_commissions_xmltagged_report($id = null) {
        $this->setup_view_commissions_xmltagged_report($id);
        return;
    }
    public function view_commissions_xmltagged_report_printable($id = null) {
        $this->layout = 'print';
        $this->setup_view_commissions_xmltagged_report($id);
        return;
    }

    public function view_commissions_tagged_report_printable($id = null) {
        $this->layout = 'print';
        $this->setup_view_commissions_tagged_report($id);
        return;
    }
    private function setup_commissions_summaries($id)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }

        $employee = $this->Employee->view_data($id);
        $hu = new HashUtilsComponent;
        //$commsrptModel = new CommissionsReport;
        $reports = $this->Employee->CommissionsReportsTag->get_employee_report_summaries($id);

        $i = 0;
        foreach ($reports as $per):
            $period = $this->Commissions->period_from_id($per['CommissionsReportsTag']['commissions_report_id']);

            $reports[$i]['CommissionsReportsTag']['period'] = $period;
            $dates = explode('-', $period);
            $reports[$i]['xml_report']['id'] = $hu->id_date_hash($employee['Employee']['id'], $dates[0]);

            $i++;
        endforeach;
        $this->set('reports', $reports);

        $this->set('employee', $employee);

        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Commissions Reports';
    }
    public function view_commissions_reports($id = null)
    {
        $this->setup_commissions_summaries($id);
    }
    public function view_commissions_reports_printable($id = null)
    {
        $this->setup_commissions_summaries($id);
        $this->layout = 'print';
    }
    public function view_notes_reports($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Employee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $employee = $this->Employee->view_notesreport_data( $id);


        $i = 0;
        foreach ($employee['CommissionsReportsTag'] as $per):
            $period = $this->Commissions->period_from_id($per['commissions_report_id']);

            $employee['CommissionsReportsTag'][$i]['period'] = $period;
            $dates = explode('-', $period);
            //$reports[$i]['xml_report']['id'] = $hu->id_date_hash($employee['Employee']['id'], $dates[0]);

            $i++;
        endforeach;


        $this->set('employee', $employee);
        $this->page_title = $employee['Employee']['firstname']. ' ';
        if($employee['Employee']['nickname']!='')
        {
            $this->page_title  .=  '('.$employee['Employee']['nickname'].') ';
        }
        $this->page_title  .=  $employee['Employee']['lastname'];
        $this->page_title .= ' Notes Reports';
    }

    public function view_contract($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->recursive = 1;
        $clientsContract = $this->Employee->ClientsContract->read(null, $id);

        $employee = $this->Employee->read(null, $clientsContract['ClientsContract']['employee_id']);
        $client = $this->Employee->ClientsContract->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
        $invoices = $this->Employee->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$id,
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $this->Employee->ClientsContract->ContractsItem->recursive=2;
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Employee->ClientsContract->ContractsItem->find('all',
            array('conditions'=>array('contract_id'=>$id,),
                'order'=>'ordering ASC',
            ));
        $count =0;
        $hours = 0;
        foreach ($invoices as $invoice):
            foreach ($invoices[$count]['InvoicesItem'] as $item):
                $hours += $item['quantity'];
            endforeach;
            $invoices[$count]['Invoice']['directLaborCost']= $this->directLaborCost($invoice['Invoice']['id']);
            $count ++;
        endforeach;

        $this->set(compact('invoices','hours','items','employee','clientsContract'));
        $this->page_title = 'View '.$client['Client']['name'].' contract general info - '.$clientsContract['ClientsContract']['title'];
    }


    public function view_mock_invoice($id = null)
    {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }
        $clientsContract = $this->Employee->ClientsContract->clientcontract_mock_invoice_manage($id);
        $this ->Employee->ClientsContract->Invoice-> fixmockinvoice($clientsContract['ClientsContract']['mock_invoice_id'],$clientsContract,$this->webroot );
        $clientsContract = $this->Employee->ClientsContract->clientcontract_mock_invoice_manage($id);

        $this->Employee->ClientsContract->ContractsItem->recursive=2;
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Employee->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
        ),'order'=>'ordering asc'));
        $employee =  $this->Employee->ClientsContract->Invoice->employeeForInvoicing($clientsContract['ClientsContract']['employee_id']);
        $this->data = $this->Employee->ClientsContract->Invoice->read(null, $clientsContract['ClientsContract']['mock_invoice_id']);


        $subject =  $this->InvoiceFunction->email_subject($this->data, $employee);


        $invoice = $this->Employee->ClientsContract->Invoice->read(Null,$clientsContract['ClientsContract']['mock_invoice_id']);
        $this->data['Invoice'] =  $invoice['Invoice'];


        $invoiceurltoken = $this->InvoiceFunction->invoiceTokenUrl($this->data, $subject, $this->webroot, $employee);

        $this->data['Invoice']['urltoken'] = $invoiceurltoken;
        $next = 'view_mock_invoice';

        $this->set(compact('items','employee','clientsContract','next'));
        $client = $this->Employee->ClientsContract->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->page_title = 'View '.$client['Client']['name'].' contract mock invoice - '.$clientsContract['ClientsContract']['title'];
    }
    public function view_contract_items($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->recursive = 1;
        $clientsContract = $this->Employee->ClientsContract->read(null, $id);
        $employee = $this->Employee->read(null, $clientsContract['ClientsContract']['employee_id']);
        $this->set('clientsContract', $clientsContract);
        $this->Employee->ClientsContract->ContractsItem->recursive=2;
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Employee->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
        ),
            'order'=>'ordering ASC'
        ));
        $next = 'view_contract_items';
        $this->set(compact('items','next','employee'));
        $client = $this->Employee->ClientsContract->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->page_title = 'View '.$client['Client']['name'].' contract billable items - '.$clientsContract['ClientsContract']['title'];
    }
    public function view_contract_invoices($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->recursive = 1;
        $clientsContract = $this->Employee->ClientsContract->read(null, $id);
        $employee = $this->Employee->read(null, $clientsContract['ClientsContract']['employee_id']);
        $invoices = $this->Employee->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $count =0;
        $hours = 0;

        foreach ($invoices as $invoice):
            foreach ($invoices[$count]['InvoicesItem'] as $item):
                $hours += $item['quantity'];
            endforeach;
            $invoices[$count]['Invoice']['directLaborCost']= $this->directLaborCost($invoice['Invoice']['id']);
            $count ++;
        endforeach;
        $this->set(compact('invoices','hours','employee','clientsContract'));
        $client = $this->Employee->ClientsContract->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->page_title = 'View '.$client['Client']['name'].' contract invoices - '.$clientsContract['ClientsContract']['title'];
    }
    public function view_contract_emails($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->recursive = 1;
        $clientsContract = $this->Employee->ClientsContract->read(null, $id);

        $employee = $this->Employee->read(null, $clientsContract['ClientsContract']['employee_id']);
        $invoices = $this->Employee->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $this->Employee->ClientsContract->ContractsItem->recursive=2;
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Employee->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
        ),));
        $count =0;
        $hours = 0;
        foreach ($invoices as $invoice):
            foreach ($invoices[$count]['InvoicesItem'] as $item):
                $hours += $item['quantity'];
            endforeach;
            $invoices[$count]['Invoice']['directLaborCost']= $this->directLaborCost($invoice['Invoice']['id']);
            $count ++;
        endforeach;
        $this->set(compact('invoices','hours','items','employee','clientsContract'));
        $client = $this->Employee->ClientsContract->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->page_title = 'View '.$client['Client']['name'].' contract invoice email recipients - '.$clientsContract['ClientsContract']['title'];
    }

    public function view_contract_invoice_details($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->recursive = 1;
        $clientsContract = $this->Employee->ClientsContract->read(null, $id);

        $employee = $this->Employee->read(null, $clientsContract['ClientsContract']['employee_id']);
        $this->set(compact('employee','clientsContract'));
    }
    public function manage_contract_items($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->recursive = 0;
        $clientsContract = $this->Employee->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Employee->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $this->Employee->ClientsContract->ContractsItem->recursive=2;
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Employee->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],

        ),));

        $count =0;
        $hours = 0;

        foreach ($invoices as $invoice):
            foreach ($invoices[$count]['InvoicesItem'] as $item):
                $hours += $item['quantity'];
            endforeach;
            $invoices[$count]['Invoice']['directLaborCost']= $this->directLaborCost($invoice['Invoice']['id']);
            $count ++;
        endforeach;

        $this->set(compact('invoices','hours','items'));
    }
    public function add() {
        if (!empty($this->data)) {

            $this->non_mobile_jqbeforesave();

            $emp = $this->data;
            $msg = '';
            $result = $this->Employee->add_employee_user_profile($emp, $msg);
            $emp=$result[0];
            $msg=$result[1];

            if($emp['Employee']['id'])
            {
                $msg .= 'The Employee has been saved<br>';
            } else {
                $msg .= 'The Employee has NOT been saved<br>';
            }
            $this->Session->setFlash(__($msg, true));
            $this->redirect(array('action'=>'view',$emp['Employee']['id']));
        } else {
            $this->Session->setFlash(__('The Employee could not be saved. Please, try again.', true));
        }
        $states = $this->Employee->State->find('list');
        $this->set(compact('states'));
        $this->page_title = 'Add Employee';
    }
    public function m_add() {
        if (!empty($this->data)) {
            $msg ='';
            $result = $this->Employee->add_employee_user_profile($this->data, $msg);
            $emp=$result[0];
            $msg=$result[1];
            if ($emp['Employee']['id']) {
                $msg .= 'The Employee has been saved';
                $this->Session->setFlash(__($msg, true));
                $this->redirect(array('prefix'=>'m','action'=>'view',$emp['Employee']['id']));
            } else {
                $this->Session->setFlash(__('The Employee could not be saved. Please, try again.', true));
            }
        }
        $states = $this->Employee->State->find('list');
        $this->set(compact('states'));
        $this->layout = "default_jqmobile_partial";
        $this->set('page_title', 'Add New Employee');
    }

    public function add_contract($employee_id = null,$step = 1, $client_id=null) {
        // In the forms
        if (!empty($this->data)) {
            $this->data['ClientsContract']['created_date'] = date('Y-m-d');
            $this->data['ClientsContract']['active'] = 1;
            if ($this->Employee->ClientsContract->add($this->data)) {
                $this->Session->setFlash(__('The Contract has been saved', true));
                $contract_id = $this->Employee->ClientsContract->getLastInsertID();
                $this->data['ClientsContract']['id']= $contract_id;
                #  add monica and invoice testers to email recipients list
                $this->data['User'][]= 12;
                $this->data['User'][]= 13;
                $this->Employee->ClientsContract->save($this->data);

                $this->redirect(array('action'=>'view_contracts',$this->data['ClientsContract']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
                $this->Employee->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
                $this->Employee->ClientsContract->Employee->unbindModel(array('belongsTo' => array('State'),),false);
                $employeesAll = $this->Employee->ClientsContract->Employee->find('all',array('conditions'=>array('active'=>1)));
                $employees = array();
                foreach ($employeesAll as $employee):
                    $employees[$employee['Employee']['id']] = $employee['Employee']['id'];
                    $employees[$employee['Employee']['name']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                endforeach;
                $periods = $this->Employee->ClientsContract->Period->find('list');
                $this->set(compact('employees', 'clients', 'states', 'periods'));
            }
        }
        # Coming in from the navs
        else
        {
            if ($employee_id == null)
            {
                $this->Session->setFlash(__('Bad Employee ID', true));
                $this->redirect(array('action'=>'index'));
            } else
            {
                if($step==1)
                {
                    $this->data['ClientsContract']['employee_id'] = $employee_id;
                    $step = 1;
                    $clientsMenu = $this->Employee->ClientsContract->Client->active_jumpto_menu();
                    $employee = $this->Employee->employeeforcontractbuild($employee_id);
                    $this->data['ClientsContract']['employee_name'] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                    $this->page_title = 'Select client for '.$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].'s new contract';
                    $this->set(compact('clientsMenu','step','employee'));
                }
                else
                {
                    $periods = $this->Employee->ClientsContract->Period->find('list');
                    $clientdata = $this->Employee->ClientsContract->Client->clientforcontractbuild($client_id);
                    $employeedata = $this->Employee->employeeforcontractbuild($employee_id);
                    $employee = $this->Employee->ClientsContract->Employee->employeeforcontractbuild($employee_id);
                    $this->data['ClientsContract']['client_name'] = $clientdata['Client']['name'];
                    $this->data['ClientsContract']['terms'] = $clientdata['Client']['terms'];
                    $this->data['ClientsContract']['client_id'] = $client_id;
                    $this->data['ClientsContract']['employee_id'] = $employee_id;

                    $this->page_title = 'Select client for '.$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].'s new contract contract';
                    $this->set(compact('periods','step','employee','clientdata'));
                }
            }
        }
    }

    public function add_letter($employee_id = null)
    {
        // In the forms
        if (!empty($this->data)) {
            //debug($this->data);exit;

            $dateA = explode('/',$this->data['EmployeesLetter']['date']);
            $this->data['EmployeesLetter']['date'] =$dateA[2].'-'.$dateA[0].'-'.$dateA[1];
            $this->Employee->EmployeesLetter->create();
            $this->Employee->EmployeesLetter->save($this->data);
            //debug($this->data);exit;
            $this->redirect(array('action'=>'view_letters',$this->data['EmployeesLetter']['employee_id']));
        }
        # Comming in from the navs
        else
        {
            if ($employee_id == null)
            {
                $this->Session->setFlash(__('Bad Employee ID', true));
                $this->redirect(array('action'=>'index'));
            } else
            {

                $encryptedEmployee = $this->Employee->read(null, $employee_id);
                $this->data = $this->Employee->decrypt($encryptedEmployee);

                $this->data['Employee']['ssn_crypto_display'] =
                    "XXX-XX-" . substr($this->data['Employee']['ssn_crypto'],-4,4);
                $this->page_title = 'Write letter for '.$this->data['Employee']['firstname'].' '.$this->data['Employee']['nickname'].' '.$this->data['Employee']['lastname'];
                $employee = array();
                $employee['Employee'] = $this->data['Employee'];
                $this->set(compact('employee'));
            }
        }
    }
    public function clients_list()
    {
        $this->Employee->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsMemo','ClientsManager','ClientsCheck','ClientsSearch'),),false);
        $this->Employee->ClientsContract->Client->unbindModel(array('belongsTo' => array('State'),),false);
        $clientsAll = $this->Employee->ClientsContract->Client->find('all',array('conditions'=>array('active'=>1)));
        $clients = array();
        foreach ($clientsAll as $client):
            $clients[$client['Client']['id']] = $client['Client']['name'];
        endforeach;
        return $clients;
    }
    public function add_expense($employee_id) {
        if (!empty($this->data)) {
            $this->Employee->Expense->create();
            if ($this->Employee->Expense->save($this->data)) {
                $this->Session->setFlash(__('The Expense has been saved', true));
                $this->redirect(array('action'=>'view_expenses'));
            } else {
                $this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
            }
        }
        $expensesCategories = $this->Employee->Expense->ExpensesCategory->find('list');
        $employees = $this->Employee->activeEmployees();

        $current_employee = $employee_id;
        $this->set(compact('expensesCategories','employees','current_employee'));
    }
    public function add_contract_item($contract_id = null,$next = null) {
        if ($contract_id == null && !isset($this->data['ContractsItem']['contract_id']))
        {
            $this->Session->setFlash(__('Bad Contract ID', true));
            $this->redirect(array('action'=>'index'));
        } else
        {
            if (!empty($this->data))
            {
                $user = $this->Auth->user();
                $this->data['ContractsItem']['created_date'] = date('Y-m-d');
                $this->data['ContractsItem']['created_user_id'] = $user['User']['id'];
                $this->data['ContractsItem']['active'] = 1;
                $this->Employee->ClientsContract->ContractsItem->create();
                if ($this->Employee->ClientsContract->ContractsItem->save($this->data)) {
                    $this->Session->setFlash(__('The Item has been saved', true));
                    $this->redirectFromContractsItem($this->data);
                } else {
                    $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
                }
            }else
            {
                $clientsContract = $this->Employee->ClientsContract->read(null, $contract_id);

                $employee = $this->Employee->read(null, $clientsContract['ClientsContract']['employee_id']);
                $client = $this->Employee->ClientsContract->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
                $this->page_title = 'Add billable item for '.$client['Client']['name'].' contract - '.$clientsContract['ClientsContract']['title'];
                $next = $this->params['named']['next'];
                $this->set(compact('next','clientsContract','employee'));
                $this->data['ContractsItem']['contract_id'] = $contract_id;
            }
        }
    }
    public function add_contract_comm_item($item_id=null,$next=null) {
        if (!empty($this->data)) { //debug($this->data);debug($next);
            $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->create();
            $this->data['ContractsItemsCommissionsItem']['created_date'] = date('Y-m-d');
            if ($this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->save($this->data)) {
                $this->Session->setFlash(__('The Commissions has been saved', true));
                $item = $this->Employee->ClientsContract->ContractsItem->read(null, $this->data['ContractsItemsCommissionsItem']['contracts_items_id']);
                $this->redirect(array('action'=>$this->data['ContractsItemsCommissionsItem']['next'],$item['ContractsItem']['contract_id']));
            } else {
                $this->Session->setFlash(__('The Commissions could not be saved. Please, try again.', true));
            }
        }
        $item = $this->Employee->ClientsContract->ContractsItem->read(null, $item_id);
        $contract = $this->Employee->ClientsContract->read(null, $item['ContractsItem']['contract_id']);
        $employee = $this->Employee->read(null, $contract['ClientsContract']['employee_id']);
        $this->data['ContractsItemsCommissionsItem']['contracts_items_id'] = $item_id;
        $this->data['ClientsContract'] = $contract['ClientsContract'];
        $this->Employee->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $this->Employee->ClientsContract->Employee->unbindModel(array('belongsTo' => array('State'),),false);
        $employeesAll = $this->Employee->find('all',array('conditions'=>array('Employee.active'=>1,'Employee.salesforce'=>1)));
        $employees = array();
        foreach ($employeesAll as $employee):
            $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        endforeach;
        $this->set(compact('employees','next','contract','employee'));
    }

    public function add_email($employee_id = null) {
        if (!empty($this->data)) {
            $this->Employee->EmployeesEmail->create();
            if ($this->Employee->EmployeesEmail->save($this->data)) {
                $this->Session->setFlash(__('The Employees\' Email has been saved', true));
                $this->redirect(array('action'=>'edit',$this->data['EmployeesEmail']['employee_id']));
            } else {
                $this->Session->setFlash(__('The EmployeesEmail could not be saved. Please, try again.', true));
            }
        }
        $employee = $this->Employee->read(null, $employee_id);
        $this->set(compact('employee'));
    }
    public function add_memo($employee_id = null) {
        if (!empty($this->data)) {
            $this->Employee->EmployeesMemo->create();
            if ($this->Employee->EmployeesMemo->save($this->data)) {
                $this->Session->setFlash(__('The Memo has been saved', true));
                $this->redirect(array('action'=>'view_memos',$this->data['EmployeesMemo']['employee_id']));
            } else {
                $this->Session->setFlash(__('The EmployeesMemo could not be saved. Please, try again.', true));
            }
        }
        $this->data['EmployeesMemo']['employee_id'] = $employee_id;
    }

    public function add_note($employee_id = null) {
        Configure::write('debug',2);
        $fmsg = '';
        if (!empty($this->data)) {
            if(!$this->data['Note']['opening'])
            {
                $fmsg .= 'note saved <br>';
                $this->data['CommissionsPayment']['amount'] = $this->data['Note']['amount'];
                $this->data['CommissionsPayment']['date'] = $this->data['Note']['date'];
                $this->data['CommissionsPayment']['description'] = $this->data['Note']['notes'];
                $this->data['CommissionsPayment']['employee_id'] = $this->data['Note']['employee_id'];
                $this->data['CommissionsPayment']['cleared'] = 0;
                $this->data['CommissionsPayment']['number'] = 0;


                $datea = array();
                $datea['month'] = $this->data['CommissionsPayment']['date']['month'];
                $datea['year'] = $this->data['CommissionsPayment']['date']['year'];


                $this->data['CommissionsPayment']['commissions_report_id'] =
                    $this->Commissions->reportID_fromdate($datea);
                $this->data['CommissionsPayment']['commissions_reports_tag_id'] =
                    $this->CommissionsReportsTag->shell_tagID($this->data['CommissionsPayment']['employee_id'],$this->data['CommissionsPayment']['commissions_report_id']);

                $this->Employee->CommissionsPayment->create();
                if ($this->Employee->CommissionsPayment->save($this->data))
                {
                    $fmsg .= 'commissions payment saved <br>';
                    $this->data['Note']['commissions_payment_id'] = $this->Employee->CommissionsPayment->getLastInsertID ();


                    $this->data['Note']['commissions_report_id'] =
                        $this->Commissions->reportID_fromdate($datea);
                    $this->data['Note']['commissions_reports_tag_id'] =
                        $this->CommissionsReportsTag->shell_tagID($this->data['Note']['employee_id'],$this->data['Note']['commissions_report_id']);

                    $this->Employee->Note->create(); //debug($this->data);exit;
                    if ($this->Employee->Note->save($this->data)) {
                        $this->data['CommissionsPayment']['note_id'] =$this->Employee->Note->getLastInsertID ();
                        $this->Employee->CommissionsPayment->save($this->data);
                        $this->Session->setFlash(__('The Note has been saved', true));
                        $this->redirect(array('action'=>'view_notes',$this->data['Note']['employee_id']));
                    } else {
                        $fmsg .= 'note NOT saved <br>';
                    }
                } else {
                    $fmsg .= 'commissions payment not saved NOT saved <br>';
                }
            } else
            {
                $this->data['Note']['commissions_payment_id'] = 0;



                $datea = array();
                $datea['month'] = date("m",strtotime($this->data['Note']['date']));
                $datea['year'] = date("Y",strtotime($this->data['Note']['date']));



                $this->data['Note']['commissions_report_id'] =
                    $this->Commissions->reportID_fromdate($datea);
                $this->data['Note']['commissions_reports_tag_id'] =
                    $this->CommissionsReportsTag->shell_tagID($this->data['Note']['employee_id'],$this->data['Note']['commissions_report_id']);
                $this->Employee->Note->create(); //debug($this->data);exit;
                if ($this->Employee->Note->save($this->data)) {
                    $fmsg .= 'note saved <br>';
                    $this->data['CommissionsPayment']['note_id'] =$this->Employee->Note->getLastInsertID ();
                    $this->Employee->CommissionsPayment->save($this->data);
                    $this->Session->setFlash(__('The Note has been saved', true));
                    $this->redirect(array('action'=>'view_notes',$this->data['Note']['employee_id']));
                } else {
                    $fmsg .= 'note NOT saved <br>';
                }
            }
        }

        $this->Session->setFlash(__('The Note could not be saved. Please, try again.', true));
        $this->data['Note']['employee_id'] = $employee_id;
    }
    public function add_commissions_payment($employee_id = null) {
        if (!empty($this->data)) {
            $this->data['CommissionsPayment']['voided'] = 0;
            $this->data['CommissionsPayment']['cleared'] = 0;
            $this->data['CommissionsPayment']['number'] = 0;

            $datea = array();
            $datea['month'] = $this->data['CommissionsPayment']['date']['month'];
            $datea['year'] = $this->data['CommissionsPayment']['date']['year'];


            $this->data['CommissionsPayment']['commissions_report_id'] =
                $this->Commissions->reportID_fromdate($datea);
            $this->data['CommissionsPayment']['commissions_reports_tag_id'] =
                $this->CommissionsReportsTag->shell_tagID($this->data['CommissionsPayment']['employee_id'],$this->data['CommissionsPayment']['commissions_report_id']);
            if ($this->Employee->CommissionsPayment->save($this->data))
            {
                $this->data['CommissionsPayment']['commissions_payment_id'] = $this->Employee->CommissionsPayment->getLastInsertID ();

                //$this->Employee->CommissionsPayment->create(); //debug($this->data);exit;
                if ($this->Employee->CommissionsPayment->save($this->data)) {
                    $this->data['CommissionsPayment']['id'] =$this->Employee->CommissionsPayment->getLastInsertID ();
                    $this->Employee->CommissionsPayment->save($this->data);
                    $this->Session->setFlash(__('The CommissionsPayment has been saved', true));
                    $this->redirect(array('action'=>'view_commissions_payments',$this->data['CommissionsPayment']['employee_id']));
                } else {
                    $this->Session->setFlash(__('The Note could not be saved. Please, try again.', true));
                }
            } else {
                $this->Session->setFlash(__('The CommissionsPayment could not be saved. Please, try again.', true));
            }
        }
        $this->data['CommissionsPayment']['employee_id'] = $employee_id;
    }
    public function add_notes_payment($employee_id = null) {
        if (!empty($this->data)) {

            Configure::write('debug',0);

            $dateA = array('year'=>$this->data['NotesPayment']['date']['year'],
                'month'=>$this->data['NotesPayment']['date']['month']);
            $this->data['NotesPayment']['commissions_report_id'] = $this->Commissions->reportID_fromdate($dateA);

            $this->data['NotesPayment']['commissions_reports_tag_id'] =
                $this->CommissionsReportsTag->shell_tagID($this->data['NotesPayment']['employee_id'],$this->data['NotesPayment']['commissions_report_id']);
            //debug($this->data['CommissionsPayment']);exit;
            $this->Employee->NotesPayment->create();
            if ($this->Employee->NotesPayment->save($this->data))
            {
                //debug($this->data['NotesPayment']);exit;
                $this->Session->setFlash(__('The NotesPayment has been saved', true));
                $this->redirect(array('action'=>'view_notes_payments',$this->data['NotesPayment']['employee_id']));

            } else {
                $this->Session->setFlash(__('The NotesPayment could not be saved. Please, try again.', true));
            }
        }
        $this->data['NotesPayment']['employee_id'] = $employee_id;
    }

    public function add_payment($employee_id = null,$step=1,$payroll=null) {
        if($step == 1)
        {
            $this->data['EmployeesPayment']['employee_id'] = $employee_id;
            $this->set('employee', $this->Employee->read(null, $employee_id));
            $this->Employee->ClientsContract->recursive = 2;
            $this->Employee->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
            $this->Employee->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
            $this->Employee->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsMemo','ClientsContract','ClientsManager','ClientsCheck','ClientsSearch'),),false);
            $this->Employee->ClientsContract->Client->unbindModel(array('belongsTo' => array('State'),),false);
            $this->Employee->ClientsContract->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
            $this->Employee->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
            # Gather list of outstanding payrolls

            $payrolls = array();
            foreach ($this->Employee->ClientsContract->find('all', array('conditions'=>array('employee_id'=>$employee_id))) as $contract)
            {
                foreach ($contract['Invoice'] as $invoice)
                {
                    if ($invoice['voided'] == 0)
                    {
                        $wage = 0;
                        $employee_payment = 0; //debug($invoice);
                        foreach ($invoice['InvoicesItem'] as $item)
                        {
                            $wage += $item['quantity']*$item['cost'];
                        }
                        foreach ($invoice['EmployeesPayment'] as $payment)
                        {
                            $employee_payment += $payment['amount'];
                        }
                        $amount_due = $wage-$employee_payment;
                        if($amount_due > 0 )
                        {
                            $payrolls[$invoice['id']] = '#'.$invoice['id'].'|'.date("m/d/Y",strtotime($invoice['period_start'])).'-'.date("m/d/Y",strtotime($invoice['period_end'])).' $'.$amount_due;
                        }
                    }
                }
            }
            $this->set('employee_id',$employee_id);
            $this->set('payrolls',$payrolls);
            $this->set('step',$step);
        } else if ($step == 2)
        {
            $this->set('employee_id',$employee_id);
            $this->set('step',$step);
            $this->Employee->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
            $invoice = $this->Employee->ClientsContract->Invoice->read(null, $payroll);
            $this->set('invoice', $invoice);
            $wage = 0;
            $employee_payment = 0;
            foreach ($invoice['InvoicesItem'] as $item)
            {
                $wage += $item['quantity']*$item['cost'];
            }
            foreach ($invoice['EmployeesPayment'] as $payment)
            {
                $employee_payment += $payment['amount'];
            }
            $amount_due = $wage-$employee_payment;
            $this->set('amount_due', $amount_due);
        } else if ($step == 3)
        {
            if (!empty($this->data)) {
                $this->Employee->EmployeesPayment->create();
                $this->data['EmployeesPayment']['securitytoken'] = $this->PasswordHelper->generatePaycheckToken();
                if ($this->Employee->EmployeesPayment->save($this->data)) {
                    $this->Session->setFlash(__('The Payment has been saved', true));
                    $this->redirect(array('action'=>'view_payments',$this->data['EmployeesPayment']['employee_id']));
                } else {
                    $this->Session->setFlash(__('The Employees Payment could not be saved. Please, try again.', true));
                }
            }
        }
    }

    public function edit($id = null) {
        $id = $this->params['pass'][0];
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Employee', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->non_mobile_jqbeforesave();

            $this->Employee->create();
            if ($this->Employee->save($this->data)) {
                $msg = 'The Employee has been saved<br>';
                $emails = $this->Employee->EmployeesEmail->find('all', array('conditions' =>
                    array('employee_id'=> $this->data['Employee']['id']),
                ));
                if(isset($emails[0]))
                {
                    $email = $emails[0];
                } else {
                    $email = array();
                    $this->Employee->EmployeesEmail->create();
                }
                $email['EmployeesEmail']['employee_id'] = $this->data['Employee']['id'];
                $email['EmployeesEmail']['email'] = $this->data['Employee']['email']; //debug($email);exit;
                if($this->Employee->EmployeesEmail->save($email))
                {
                    $msg .= 'The email has been saved<br>';
                } else {
                    $msg .= 'The email has NOT been saved<br>';
                }
                $this->Session->setFlash(__($msg, true));
            } else {

                $this->Session->setFlash(__('The Employee could not be saved. Please, try again.', true));//debug($this->data);exit;
            }

            $this->redirect(array('action'=>'view',$this->data['Employee']['id']));
        }
        if (empty($this->data)) {
            $encryptedEmployee = $this->Employee->read(null, $id);
            $this->data = $this->Employee->decrypt($encryptedEmployee);

            $this->data['Employee']['ssn_crypto_display'] =
                "XXX-XX-" . substr($this->data['Employee']['ssn_crypto'],-4,4);
            $this->page_title = 'Edit '.$this->data['Employee']['firstname'].' '.$this->data['Employee']['nickname'].' '.$this->data['Employee']['lastname'];

            $empemails =$this->Employee->EmployeesEmail->find('all',array('conditions'=>array('employee_id'=>$this->data['Employee']['id'])));
            $this->set(compact('empemails'));
            //debug($this->data );exit;
        }

        $states = $this->Employee->State->find('list');
        $this->set(compact('states'));
        $this->layout = 'default_jqmenu_jq1.8.2';
    }

    public function m_edit($id = null, $type=null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Employee', true));
            $this->redirect(array('action'=>'m_index'));
        }

        if (!empty($this->data)) {
            //debug($this->params);//exit;
            if(isset($this->params['form']['dobyear'])&&isset($this->params['form']['dobmonth'])&&isset($this->params['form']['dobday']))
                $this->data['Employee']['dob']=
                    $this->params['form']['dobyear'].'-'.
                    str_pad ($this->params['form']['dobmonth'],2,'0',STR_PAD_LEFT).'-'.
                    str_pad ($this->params['form']['dobday'],2,'0',STR_PAD_LEFT);

            if(isset($this->params['form']['year'])&&isset($this->params['form']['month'])&&isset($this->params['form']['day']))
                $this->data['Employee']['startdate']=
                    $this->params['form']['year'].'-'.
                    str_pad ($this->params['form']['month'],2,'0',STR_PAD_LEFT) .'-'.
                    str_pad ($this->params['form']['day'],2,'0',STR_PAD_LEFT);

            if(isset($this->params['form']['endyear'])&&isset($this->params['form']['endmonth'])&&isset($this->params['form']['endday']))
                $this->data['Employee']['enddate']=
                    $this->params['form']['endyear'].'-'.
                    str_pad ($this->params['form']['endmonth'],2,'0',STR_PAD_LEFT).'-'.
                    str_pad ($this->params['form']['endday'],2,'0',STR_PAD_LEFT);

            $this->data['Employee']['modified_date'] = date('Y-m-d H:m:s');

            if(isset($this->data['Employee']['firstname']))
                $this->data['Employee']['firstname']= strtoupper ( $this->data['Employee']['firstname']);
            if(isset($this->data['Employee']['lastname']))
                $this->data['Employee']['lastname']= strtoupper ( $this->data['Employee']['lastname']);
            if(isset($this->data['Employee']['street1']))
                $this->data['Employee']['street1']= strtoupper ( $this->data['Employee']['street1']);
            if(isset($this->data['Employee']['street2']))
                $this->data['Employee']['street2']= strtoupper ( $this->data['Employee']['street2']);
            if(isset($this->data['Employee']['city']))
                $this->data['Employee']['city']= strtoupper ( $this->data['Employee']['city']);
            if ($this->Employee->save($this->data)) {
                $this->Session->setFlash(__('The Employee has been saved', true));
                $this->redirect(array('prefix'=>'m','action'=>'index',$this->data['Employee']['id'] ));
            } else {
                $this->Session->setFlash(__('The Employee could not be saved. Please, try again.', true));
                $this->redirect(array('prefix'=>'m','action'=>'index' ));
            }
        }
        if (empty($this->data)) {
            $encryptedEmployee = $this->Employee->read(null, $id);
            $this->data = $this->Employee->decrypt($encryptedEmployee);

            $this->data['Employee']['ssn_crypto_display'] =
                "XXX-XX-" . substr($this->data['Employee']['ssn_crypto'],-4,4);
        }
        $states = $this->Employee->State->find('list');
        $this->set(compact('states'));
        if(!$type)
        {
            $type='edit';
        }
        $this->set(compact('type'));
        $this->layout = "default_jqmobile_partial";
        $this->set('page_title', $this->data['Employee']['firstname'].' '.$this->data['Employee']['lastname']);

        if(!$type)
            return;
        elseif($type == 'w4')
            $this -> render('m_edit_w4');
        elseif($type == 'i9')
            $this -> render('m_edit_i9');
        elseif($type == 'status')
            $this -> render('m_edit_status');
        elseif($type == 'banking')
            $this -> render('m_edit_banking');
        elseif($type == 'terminate')
            $this -> render('m_edit_terminate');
        elseif($type == 'dates')
            $this -> render('m_edit_dates');
    }
    public function edit_contract($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsContract', true));
            $this->redirect(array('action'=>'index'));
        }//debug($this->data);
        if (!empty($this->data)) {
            $this->data['ClientsContract']['ClientsManager'] = $this->data['Clients']['ClientsManager'];
            $this->data['ClientsContract']['User'] = $this->data['Clients']['User'];
            if ($this->Employee->ClientsContract->save($this->data)) {
                $this->Session->setFlash(__('The Contract has been saved', true));
                $this->redirect(array('action'=>'view_contract',$this->data['ClientsContract']['id']));
            } else {
                $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->ClientsContract->read(null, $id);
            $employees = $this->Employee->ClientsContract->Employee->find('list');
            $clients = $this->Employee->ClientsContract->Client->find('list');
            $periods = $this->Employee->ClientsContract->Period->find('list');
            $managers = $this->Employee->ClientsContract->ClientsManager->find('all',array(
                'conditions'=>array('client_id'=>$this->data['ClientsContract']['client_id']),
                'order'=>array("firstname ASC","lastname ASC"),
            ));
            $users = $this->Employee->ClientsContract->User->find('all');
            $managersoptions = array();
            $usersoptions = array();
            foreach ($managers as $manager):
                $managersoptions[$manager['ClientsManager']['id']] = $manager['ClientsManager']['title'].':'.$manager['ClientsManager']['firstname'].' '.$manager['ClientsManager']['lastname'].' '.$manager['ClientsManager']['email'];
            endforeach;
            foreach ($users as $user):
                $usersoptions[$user['User']['id']] = $user['User']['firstname'].' '.$user['User']['lastname'].' '.$user['User']['email'];
            endforeach;
            $this->set(compact('employees','clients','periods','managersoptions','usersoptions'));
        }

    }


    public function manage_contract_emails($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsContract', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {

            $this->data['ClientsManager'] = $this->data['Clients']['ClientsManager'];
            $this->data['User'] = $this->data['Clients']['User'];//debug($this->data);exit;
            if ($this->Employee->ClientsContract->save($this->data)) {
                $this->Session->setFlash(__('The Contract has been saved', true));
                $this->redirect(array('action'=>'view_contract',$this->data['ClientsContract']['id']));
            } else {
                $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->ClientsContract->read(null, $id);
            $employees = $this->Employee->ClientsContract->Employee->find('list');
            $clients = $this->Employee->ClientsContract->Client->find('list');
            $periods = $this->Employee->ClientsContract->Period->find('list');
            $managers = $this->Employee->ClientsContract->ClientsManager->find('all',array(
                'conditions'=>array('client_id'=>$this->data['ClientsContract']['client_id']),
                'order'=>array("firstname ASC","lastname ASC"),
            ));
            $users = $this->Employee->ClientsContract->User->find('all',array('conditions'=>array('group_id'=>1)));
            $managersoptions = array();
            $usersoptions = array();
            foreach ($managers as $manager):
                $managersoptions[$manager['ClientsManager']['id']] = $manager['ClientsManager']['title'].':'.$manager['ClientsManager']['firstname'].' '.$manager['ClientsManager']['lastname'].' '.$manager['ClientsManager']['email'];
            endforeach;
            foreach ($users as $user):
                $usersoptions[$user['User']['id']] = $user['User']['firstname'].' '.$user['User']['lastname'].' '.$user['User']['email'];
            endforeach;
            $this->set(compact('employees','clients','periods','managersoptions','usersoptions'));
        }

    }
    public function edit_expense($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Expense', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Employee->Expense->save($this->data)) {
                $this->Session->setFlash(__('The Expense has been saved', true));
                $this->redirect(array('controller'=>'employees','action'=>'view_expenses',$this->data['Expense']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->Expense->read(null, $id);
        }
        //debug($this->data);exit;
        $expensesCategories = $this->Employee->Expense->ExpensesCategory->find('list');
        $current_employee = $this->data['Expense']['employee_id'];
        $employees = $this->Employee->activeEmployees();
        $this->set(compact('expensesCategories','employees','current_employee'));
    }
    public function edit_contract_item_submit() {
        //debug($this->data);exit;
        if (!empty($this->data)) { //
            //debug($this->data);
            $item = $this->Employee->ClientsContract->ContractsItem->read(null, $this->data['ContractsItem']['id']);//debug($item);//exit;
            if ($this->Employee->ClientsContract->ContractsItem->save($this->data)) {
                $next = $this->data['ContractsItem']['next'];
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->data['ContractsItem']= $item['ContractsItem'];
                $this->data['ContractsItem']['next']= $next;
                $this->redirect(array('action'=>$this->data['ContractsItem']['next'],$item['ContractsItem']['contract_id']));

            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        //debug($this->data);exit;
        if (empty($this->data)) {
            $this->data = $this->Employee->ClientsContract->ContractsItem->read(null, $id);
            $this->data['ClientsContract'] = $this->Employee->ClientsContract->read(null, $this->data['ContractsItem']['contract_id']);

            $clientsContract = $this->Employee->ClientsContract->read(null, $this->data['ContractsItem']['contract_id']);
            $client = $this->Employee->ClientsContract->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
            $this->page_title = 'Edit billable item for '.$client['Client']['name'].' contract - '.$clientsContract['ClientsContract']['title'];

            $this->set(compact('next'));
        }
    }
    public function edit_contract_item($id = null,$contract_id=null,$next=null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ContractsItem', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) { //debug($this->data);//exit;

            $user = $this->Auth->user();
            $this->data['ContractsItem']['modified_date'] = date('Y-m-d');
            $this->data['ContractsItem']['modified_user_id'] = $user['User']['id'];
            // get old version of item for navigation??
            $item = $this->Employee->ClientsContract->ContractsItem->read(null, $this->data['ContractsItem']['id']);//debug($item);//exit;
            if ($this->Employee->ClientsContract->ContractsItem->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->data['ContractsItem']= $item['ContractsItem'];
                $this->data['ContractsItem']['next']= $next;
                $this->redirectFromContractsItem($this->data);
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->ClientsContract->ContractsItem->read(null, $id);
            $this->data['ClientsContract'] = $this->Employee->ClientsContract->read(null, $this->data['ContractsItem']['contract_id']);

            $clientsContract = $this->Employee->ClientsContract->read(null, $this->data['ContractsItem']['contract_id']);
            $client = $this->Employee->ClientsContract->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
            $this->page_title = 'Edit billable item for '.$client['Client']['name'].' contract - '.$clientsContract['ClientsContract']['title'];
            //debug($next);exit;
            $this->set(compact('next'));
        }
    }

    public function edit_contract_comm_item_fix() {
        if ( empty($this->data)) {
            debug('bad');debug($this->data);debug('bad');debug($_POST);exit;
            $this->Session->setFlash(__('Invalid ContractsItemsCommissionsItem', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->save($this->data))
        {
            $this->Session->setFlash(__('The Commissions has been saved', true));
            $citem = $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $this->data['ContractsItemsCommissionsItem']['id']);
            $item = $this->Employee->ClientsContract->ContractsItem->read(null, $citem['ContractsItemsCommissionsItem']['contracts_items_id']);
            //debug($item);debug($this->data);exit;
            $this->redirect(array('action'=>$this->data['ContractsItemsCommissionsItem']['next'],$item['ContractsItem']['contract_id']));
        } else {
            $this->Session->setFlash(__('The Commissions could not be saved. Please, try again.', true));
        }


        exit;
    }
    public function edit_contract_comm_item($id = null,$contract_id=null, $next=null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ContractsItemsCommissionsItem', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->save($this->data)) {
                $this->Session->setFlash(__('The Commissions has been saved', true));
                $citem = $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $this->data['ContractsItemsCommissionsItem']['id']);
                $item = $this->Employee->ClientsContract->ContractsItem->read(null, $citem['ContractsItemsCommissionsItem']['contracts_items_id']);
                $this->redirect(array('action'=>$next,$contract_id));
            } else {
                $this->Session->setFlash(__('The Commissions could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $id);
        }
        $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->Employee->unbindModel(array('belongsTo' => array('State'),),false);

        $employeesAll = $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->Employee->find('all',array('conditions'=>array('salesforce'=>1)));
        $employees = array();
        foreach ($employeesAll as $employee):
            $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        endforeach;
        $item = $this->Employee->ClientsContract->ContractsItem->read(null, $this->data['ContractsItemsCommissionsItem']['contracts_items_id']);
        $this->Employee->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Client','Period'),),false);
        $this->Employee->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->Employee->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('User','ClientsManager'),),false);
        $contract = $this->Employee->ClientsContract->read(null, $item['ContractsItem']['contract_id']);
        $employee = $this->Employee->read(null, $contract['ClientsContract']['employee_id']);
        $this->set(compact('employees','contract','next','employee'));
    }

    public function edit_email($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Employees Email', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Employee->EmployeesEmail->save($this->data)) {
                $this->Session->setFlash(__('The Employees Email has been saved', true));
                $this->redirect(array('action'=>'edit',$this->data['EmployeesEmail']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Employees Email could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->EmployeesEmail->read(null, $id);
        }
    }
    public function edit_memo($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid EmployeesMemo', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Employee->EmployeesMemo->save($this->data)) {
                $this->Session->setFlash(__('The Memo has been saved', true));
                $this->redirect(array('action'=>'view_memos',$this->data['EmployeesMemo']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->EmployeesMemo->read(null, $id);
        }
        $this->page_title = 'Edit '.$this->data['Employee']['firstname'].' '.$this->data['Employee']['lastname'].'s memo';
        $employees = $this->Employee->EmployeesMemo->Employee->find('list');
        $this->set(compact('employees'));
    }

    public function preview_letter_pdf($id,$display= null)
    {
        $this->Employee->EmployeesLetter->generatepdf($id,1);
        $this->redirect(array('action'=>'view_letter'.$id));
    }
    public function edit_letter($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid EmployeesLetter', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $dateA = explode('/',$this->data['EmployeesLetter']['date']);
            $this->data['EmployeesLetter']['date'] =$dateA[2].'-'.$dateA[0].'-'.$dateA[1];
            if ($this->Employee->EmployeesLetter->save($this->data)) {
                $this->Session->setFlash(__('The Letter has been saved', true));
                $this->redirect(array('action'=>'view_letters',$this->data['EmployeesLetter']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Letters could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->EmployeesLetter->read(null, $id);
        }
        $this->page_title = 'Edit '.$this->data['Employee']['firstname'].' '.$this->data['Employee']['lastname'].'s letter';

    }
    public function edit_payment($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid EmployeesPayment', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Employee->EmployeesPayment->save($this->data)) {
                $this->Session->setFlash(__('The EmployeesPayment has been saved', true));
                $this->redirect(array('action'=>$this->data['EmployeesPayment']['next'],$this->data['EmployeesPayment']['employee_id']));
            } else {
                $this->Session->setFlash(__('The EmployeesPayment could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->EmployeesPayment->read(null, $id);

            $next = $this->params['named']['next'];
            $this->set(compact('next'));
            $contract = $this->Employee->ClientsContract->read(null,$this->data['Invoice']['contract_id']);
            $employee =$this->Employee->view_data( $contract['ClientsContract']['employee_id']);

            $this->set(compact('employee'));
            $this->page_title = 'Edit Payment #'.$this->data['EmployeesPayment']['ref'].' for employee '.$employee['Employee']['firstname'].' '.
                $employee['Employee']['lastname'].' for the period '.
                date('m/d/Y',strtotime($this->data['Invoice']['period_start'])).' - '.
                date('m/d/Y',strtotime($this->data['Invoice']['period_end']));
        }
    }
    public function edit_commissions_payment($id = null) {

        Configure::write('debug', 2);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid CommissionsPayment', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            //debug($this->data);exit;
            if ($this->data['CommissionsPayment']['note_id'])
            {

                $datea = array();
                $datea['month'] = $this->data['CommissionsPayment']['date']['month'];
                $datea['year'] = $this->data['CommissionsPayment']['date']['year'];
                $this->data['CommissionsPayment']['commissions_report_id'] =
                    $this->Commissions->reportID_fromdate($datea);
                $this->data['CommissionsPayment']['commissions_reports_tag_id'] =
                    $this->CommissionsReportsTag->shell_tagID($this->data['CommissionsPayment']['employee_id'],$this->data['CommissionsPayment']['commissions_report_id']);

                $note = $this->Employee->Note->read(null,$this->data['CommissionsPayment']['note_id']);
                //debug($note);
                $note['Note']['notes'] = $this->data['CommissionsPayment']['description'];
                $note['Note']['amount'] = $this->data['CommissionsPayment']['amount'];
                $note['Note']['date'] = $this->data['CommissionsPayment']['date'];
                $note['Note']['cleared'] = $this->data['CommissionsPayment']['cleared'];
                $note['Note']['commissions_report_id'] = $this->data['CommissionsPayment']['commissions_report_id'];
                $note['Note']['commissions_reports_tag_id'] = $this->data['CommissionsPayment']['commissions_reports_tag_id'];
                //debug($note);exit;
                if ($this->Employee->Note->save($note))
                {
                    $msg = 'Commissions Payment updated <br>';
                }
            } else {


                $datea = array();
                $datea['month'] = $this->data['CommissionsPayment']['date']['month'];
                $datea['year'] = $this->data['CommissionsPayment']['date']['year'];

                $this->data['CommissionsPayment']['commissions_report_id'] =
                    $this->Commissions->reportID_fromdate($datea);
                $this->data['CommissionsPayment']['commissions_reports_tag_id'] =
                    $this->CommissionsReportsTag->shell_tagID(
                        $this->data['CommissionsPayment']['employee_id'],$this->data['CommissionsPayment']['commissions_report_id']);


            }
            if ($this->Employee->CommissionsPayment->save($this->data)) {
                $msg .= 'The CommissionsPayment has been saved';
                $this->Session->setFlash(__($msg, true));
                $this->redirect(array('action'=>'view_commissions_payments',$this->data['CommissionsPayment']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Note could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->CommissionsPayment->read(null, $id);

            $employee =$this->Employee->view_data( $this->data['CommissionsPayment']['employee_id']);

            $this->set(compact('employee'));
            $this->page_title = 'Edit CommissionsPayment #'.$this->data['CommissionsPayment']['check_number'].' for employee '.$employee['Employee']['firstname'].' '.
                $employee['Employee']['lastname'];
        }
    }
    public function edit_notes_payment($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid NotesPayment', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {

            $this->data['NotesPayment']['date'] =
                $this->data['NotesPayment']['date']['year'].'-'.$this->data['NotesPayment']['date']['month'].'-'
                .$this->data['NotesPayment']['date']['day'];

            $sarr = split('-', $this->data['NotesPayment']['date']);
            $dateA = array('year'=>$sarr[0],
                'month'=>$sarr[1]);
            $this->data['NotesPayment']['commissions_report_id'] = $this->Commissions->reportID_fromdate($dateA);

            $this->data['NotesPayment']['commissions_reports_tag_id'] =
                $this->CommissionsReportsTag->shell_tagID($this->data['NotesPayment']['employee_id'],$this->data['NotesPayment']['commissions_report_id']);

            if ($this->Employee->NotesPayment->save($this->data))
            {
                $msg = 'Notes Payment updated <br>';
                $this->Session->setFlash(__($msg, true));
                $this->redirect(array('action'=>'view_notes_payments',$this->data['NotesPayment']['employee_id']));
            }else {
                $this->Session->setFlash(__('The Note could not be saved. Please, try again.', true));
            }

        }
        if (empty($this->data)) {
            $this->data = $this->Employee->NotesPayment->read(null, $id);

            $employee =$this->Employee->view_data( $this->data['NotesPayment']['employee_id']);

            $this->set(compact('employee'));
            $this->page_title = 'Edit NotesPayment #'.$this->data['NotesPayment']['check_number'].' for employee '.$employee['Employee']['firstname'].' '.
                $employee['Employee']['lastname'];
        }
    }
    public function edit_note($id = null) {
        Configure::write('debug',2);
        /*
         * Post only works when security component is turned off
         *

        */
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Note', true));

            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {

            if ($this->data['Note']['commissions_payment_id'])
            {

                $datea = array();
                $datea['month'] = $this->data['Note']['date']['month'];
                $datea['year'] = $this->data['Note']['date']['year'];


                $this->data['Note']['commissions_report_id'] =
                    $this->Commissions->reportID_fromdate($datea);
                $this->data['Note']['commissions_reports_tag_id'] =
                    $this->CommissionsReportsTag->shell_tagID($this->data['Note']['employee_id'],$this->data['Note']['commissions_report_id']);


                $cpayment = $this->Employee->CommissionsPayment->read(null,$this->data['Note']['commissions_payment_id']);
                //debug($note);
                $cpayment['CommissionsPayment']['description'] = $this->data['Note']['notes'];
                $cpayment['CommissionsPayment']['amount'] = $this->data['Note']['amount'];
                $cpayment['CommissionsPayment']['date'] = $this->data['Note']['date'];
                $cpayment['CommissionsPayment']['cleared'] = 0;
                $cpayment['CommissionsPayment']['commissions_report_id'] = $this->data['Note']['commissions_report_id'];
                $cpayment['CommissionsPayment']['commissions_reports_tag_id'] = $this->data['Note']['commissions_reports_tag_id'];
                //debug($note);exit;
                if ($this->Employee->CommissionsPayment->save($cpayment))
                {
                    $msg = 'Commissions Payment updated <br>';
                }
            }
            if ($this->Employee->Note->save($this->data)) {
                $msg .= 'The note has been saved';//debug($this->data['CommissionsPayment']);exit;
                $this->Session->setFlash(__($msg, true));
                $this->redirect(array('action'=>'view_notes',$this->data['Note']['employee_id']));
            } else {
                $this->Session->setFlash(__('The Note could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->Note->read(null, $id);
            $employee =$this->Employee->view_data( $this->data['Note']['employee_id']);
            $this->set(compact('employee'));
            $this->page_title = 'Edit Note #'.$this->data['Note']['id'].' for employee '.$employee['Employee']['firstname'].' '.
                $employee['Employee']['lastname'];
        }
    }
    public function edit_invoice($id = null) {
        if (!empty($this->data)) {
            unset($this->data['Invoice']['period_start']);
            unset($this->data['Invoice']['period_end']);
            unset($this->data['Invoice']['date']);
            $contract = $this->Employee->ClientsContract->read(null, $this->data['Invoice']['contract_id']);
            $this->Employee->ClientsContract->Invoice->save($this->data);
            //debug($this->data);debug($contract);exit;
            $this->redirect(array('action'=>$this->data['Invoice']['next'].'/'.$contract['ClientsContract']['employee_id']));
        }
        if (empty($this->data)) {
            $this->data = $this->Employee->ClientsContract->Invoice->read(null, $id);
            $next = $this->params['named']['next'];
            $this->set(compact('next'));
            $contract = $this->Employee->ClientsContract->read(null,$this->data['Invoice']['contract_id']);
            $employee =$this->Employee->view_data( $contract['ClientsContract']['employee_id']);

            $this->set(compact('employee'));
            $this->page_title = 'Edit Invoice #'.$this->data['Invoice']['contract_id'].' for employee '.$employee['Employee']['firstname'].' '.
                $employee['Employee']['lastname'].' for the period '.
                date('m/d/Y',strtotime($this->data['Invoice']['period_start'])).' - '.
                date('m/d/Y',strtotime($this->data['Invoice']['period_end']));
        }
    }
    public function edit_mock_invoice($invoice_id = null)
    {
        if(empty($this->data))
        {
            if($invoice_id)
            {
                $clientsContract = $this->Employee->ClientsContract->clientcontract_mock_invoice_manage($this->data['Invoice']['contract_id']);
                $employeesRaw = $this->Employee->find('all',null);
                $employees = Array();
                foreach($employeesRaw as $employee)
                {
                    $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                }
                $this->set('employees', $employees);
                $this->set('clientsContract', $clientsContract);
            }
        } else {
            $res = $this->Employee->ClientsContract->Invoice->save_dynamic($this->data);

            $this->redirect(array('action'=>'view_mock_invoice',$this->data['Invoice']['contract_id']));
        }
    }


    public function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Employee', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Employee->delete($id)) {
            $this->Session->setFlash(__('Employee deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

    public function delete_expense($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Expense', true));
            $this->redirect(array('action'=>'view_expenses'));
        }
        $expense = $this->Employee->Expense->read(Null,$id);
        //debug($expense);exit;
        if ($this->Employee->Expense->delete($id)) {
            $this->Session->setFlash(__('Expense deleted', true));
            $this->redirect(array('action'=>'view_expenses',$expense['Expense']['employee_id']));
        }
    }

    public function delete_payment($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for EmployeesPayment', true));
            $this->redirect(array('action'=>'index'));
        }
        $payment = $this->Employee->EmployeesPayment->read(null, $id);
        if ($this->Employee->EmployeesPayment->delete($id)) {
            $this->Session->setFlash(__('EmployeesPayment deleted', true));
            $this->redirect(array('action'=>'view',$payment['EmployeesPayment']['employee_id']));
        }
    }
    public function delete_contract($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Contract', true));
            $this->redirect(array('action'=>'index'));
        }
        $contract = $this->Employee->ClientsContract->read(null, $id);
        if ($this->Employee->ClientsContract->delete($id, true)) {
            $this->Session->setFlash(__('Contract deleted', true));
            $this->redirect(array('action'=>'view_contracts',$contract['ClientsContract']['employee_id']));
        } else {
            $this->Session->setFlash(__('Could not delete contract from employees controller'));
            $this->redirect(array('action'=>'view_contracts',$contract['ClientsContract']['employee_id']));
        }
    }
    public function delete_contract_item($id = null,$contract_id = null,$next=null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Item', true));
            $this->redirect(array('action'=>'index'));
        }
        $item = $this->Employee->ClientsContract->ContractsItem->read(null, $id);//debug($item);exit;
        if ($this->Employee->ClientsContract->ContractsItem->delete($id)) {
            $this->Session->setFlash(__('Item deleted', true));
            $this->redirect(array('action'=>$next, $contract_id));
        }
    }

    public function delete_contract_comm_item($id = null,$contract_id=null,$next=null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Commissions', true));
            $this->redirect(array('action'=>'index'));
        }
        $citem = $this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $id);
        $item = $this->Employee->ClientsContract->ContractsItem->read(null, $citem['ContractsItemsCommissionsItem']['contracts_items_id']);
        if ($this->Employee->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->delete($id)) {
            $this->Session->setFlash(__('Commissions Item deleted', true));
            $this->redirect(array('action'=>$next,$contract_id));
        }
        $this->redirect(array('action'=>$next,$contract_id));
    }


    public function delete_email($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for EmployeesEmail', true));
            $this->redirect(array('action'=>'index'));
        }
        $email= $this->data = $this->Employee->EmployeesEmail->read(null, $id);

        if ($this->Employee->EmployeesEmail->delete($id)) {
            $this->Session->setFlash(__('Employees Email deleted', true));
            $this->redirect(array('action'=>'edit',$email['EmployeesEmail']['employee_id']));
        }
    }
    public function delete_memo($id = null,$employee_id) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for EmployeesMemo', true));
            $this->redirect(array('action'=>'view_memos',$employee_id));
        }
        $memo = $this->Employee->EmployeesMemo->read(null, $id);
        if ($this->Employee->EmployeesMemo->delete($id)) {
            $this->Session->setFlash(__('Memo deleted', true));
            $this->redirect(array('action'=>'view_memos',$memo['EmployeesMemo']['employee_id']));
        }
    }

    public function delete_letter($id = null,$employee_id) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for EmployeesLetter', true));
            $this->redirect(array('action'=>'view_letters','id'=>$employee_id));
        }
        $letter = $this->Employee->EmployeesLetter->read(null, $id);

        if ($this->Employee->EmployeesLetter->delete($id)) {
            $this->Session->setFlash(__('Letter deleted', true));
            $this->redirect(array('action'=>'view_letters',$letter['EmployeesLetter']['employee_id']));
        }
    }
    public function delete_note($id = null,$employee_id) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for EmployeesMemo', true));
            $this->redirect(array('action'=>'view_memos',$employee_id));
        }
        $note = $this->Employee->Note->read(null, $id);
        $employee = $this->Employee->read(null, $employee_id);
        $msg='';
        if ($note['Note']['commissions_payment_id'])
        {
            if ($this->Employee->CommissionsPayment->delete($note['Note']['commissions_payment_id']))
            {
                $msg = 'Commissions Payment deleted';
            }
        }
        if ($this->Employee->Note->delete($id)) {
            $msg .= 'Note deleted';
            $this->Session->setFlash(__($msg, true));
        }
        $this->redirect(array('action'=>'view_notes',$note['Note']['employee_id']));
    }
    public function delete_commissions_payment($id = null,$employee_id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for CommissionsPayment', true));
            $this->redirect(array('action'=>'view_commissions_payments',$employee_id));
        }
        $payment = $this->Employee->CommissionsPayment->read(null, $id);
        if ($this->Employee->CommissionsPayment->delete($id)) {
            $this->Session->setFlash(__('CommissionsPayment deleted', true));
            $this->redirect(array('action'=>'view_commissions_payments',$payment['CommissionsPayment']['employee_id']));
        }
    }

    public function delete_notes_payment($id = null,$employee_id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for NotesPayment', true));
            $this->redirect(array('action'=>'view_cnotes_payments',$employee_id));
        }
        $payment = $this->Employee->NotesPayment->read(null, $id);
        if ($this->Employee->NotesPayment->delete($id)) {
            $this->Session->setFlash(__('NotesPayment deleted', true));
            $this->redirect(array('action'=>'view_notes_payments',$payment['NotesPayment']['employee_id']));
        }
    }
    public function search() {
        if (!empty($this->data)) {
            $this->Employee->recursive=1;
            $employees = $this->Employee->find('all', array(
                    'conditions'=>array(
                        'Employee.firstname like "%'.$this->data['Employee']['firstname'].'%"',
                        'Employee.lastname like "%'.$this->data['Employee']['lastname'].'%"',
                        'Employee.nickname like "%'.$this->data['Employee']['nickname'].'%"',
                        'Employee.state_id like "%'.$this->data['Employee']['state_id'].'%"',
                    ),
                    'limit' => 100 ,
                    'order' => array('Employee.startdate'=>'DESC',),

                )
            );
            $this->set('employees', $employees);
        } else
        {
            $states = $this->Employee->State->find('list');
            $this->set(compact('states'));
        }
    }
    public function rebuild_mock_invoice($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Employee->ClientsContract->Invoice->rebuild_invoice($id);
        $this->redirect(array('action'=>'edit_mock_invoice/'.$id));
    }

    public function select_labels() {
        $this->Employee->recursive = 0;
        $employees = $this->Employee->find('all', array(
            'fields'=>array('id','firstname','lastname','phone','dob',
                'startdate','street1','city','zip','usworkstatus','tcard','w4','de34','i9','medical','indust','info'),
            'conditions'=>array('active'=>1,'voided'=>0)
        ));
        $this->set(compact('employees'));
        $this->page_title = 'Select Employees';
        $jsonComp = new JsonComponent;
        $this->set('employeesControl', $jsonComp->employees_json($employees));
    }
    /* called from radio buttons in index list */
    function soap_timecard()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['tcard']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
            return;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_activeinactive()
    {
        $this->layout = Null;
        $this->data['Employee']['enddate'] = $this->params['form']['year'].'-'.$this->params['form']['month'].'-'.$this->params['form']['day'];
        $this->data['Employee']['id']=$this->params['form']['id'];
        $this->data['Employee']['active']=$this->params['form']['active'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
        header('Content-type: application/json');
        echo '{ "result":'.$this->params['form']['active'].'}';
        return ;
    }
    /* called from radio buttons in index list */
    function soap_voided()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['voided']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_w4()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['w4']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_de34()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['de34']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_i9()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['i9']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_medical()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['medical']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_indust()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['indust']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /* called from radio buttons in index list */
    function soap_info()
    {
        $this->layout = Null;
        $this->data['Employee']['id'] = $this->params['form']['id'];
        $this->data['Employee']['info']= $this->params['form']['vote'];
        if ($this->Employee->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    /*
     *  ajax call to open new window with label sheet pdf
     *  the first call.
     *  writes down fixture file. with selected employee list
     *  second call calls new wihdow on labels pdf
     */
    function soap_labels_pdf()
    {
        Configure::write('debug',0);
        $this->Employee->recursive = 0;
        if (empty($this->data['Employee']['Employee'])) {
            header('Content-type: application/json');
            echo '{ "result":"1","message":"no employees selected"}';
            return;
        }
        if (!empty($this->data['Employee']['Employee'])) {
            $user = $this->Auth->user();
            $fixobj=array();
            if(isset($this->params['form']['mode']))
            {
                $fixobj['mode']=$this->params['form']['mode'];
            }
            $fixobj['fixture-random']=$this->params['form']['fixture-random'];
            $fixobj['user_id']=$user['User']['id'];
            $fixobj['user_email']=$this->params['form']['user_email'];
            $fixobj['row']=$this->params['form']['row'];
            $fixobj['column']=$this->params['form']['column'];

            # is this the same for payrolls
            $fixobj['Employee']=$this->data['Employee']['Employee'];
            $jsonComp = new JsonComponent;
            $fixstr = $jsonComp->json_label_fixture($fixobj);
            $fully_qualified_fixture_filename =$jsonComp->labelFixtureFullyQualifiedFilename($fixobj);
            $f = fopen($fully_qualified_fixture_filename,'w+');
            fwrite($f,$fixstr);
            fclose($f);

            $empComp = new EmployeeComponent;
            $pdf = $empComp->build_label_sheet_from_fixture($fully_qualified_fixture_filename);
            header('Content-type: application/json');
            echo '{ "result":"0","message":"Please Review Label Sheet for Emailing"}';
            exit;
        }
    }
    function soap_payrolls_labels_pdf()
    {
        Configure::write('debug',2);
        $this->Employee->recursive = 0;
        if (empty($this->params['form'])) {
            header('Content-type: application/json');
            echo '{ "result":"1","message":"no employees selected"}';
            return;
        }
        if (!empty($this->params['form'])) {
            $user = $this->Auth->user();
            $fixobj=array();
            if(isset($this->params['form']['mode']))
            {
                $fixobj['mode']=$this->params['form']['mode'];
            } else {
                $fixobj['mode']=0;
            }
            $fixobj['fixture-random']=$this->params['form']['fixture-random'];
            $fixobj['user_id']=$user['User']['id'];
            $fixobj['user_email']=$this->params['form']['user_email'];
            $fixobj['row']=$this->params['form']['row'];
            $fixobj['column']=$this->params['form']['column'];
            # is this the same for payrolls
            $fixobj['employees']= $this->params['form']['employees'];

            $jsonComp = new JsonComponent;
            $fixstr = $jsonComp->soap_json_label_fixture($fixobj);

            $fully_qualified_fixture_filename =$jsonComp->labelFixtureFullyQualifiedFilename($fixobj);

            $f = fopen($fully_qualified_fixture_filename,'w+');
            fwrite($f,$fixstr);
            fclose($f);

            $empComp = new EmployeeComponent;

            $pdf = $empComp->build_label_sheet_from_fixture($fully_qualified_fixture_filename);

            header('Content-type: application/json');
            echo '{ "result":"0","message":"Please Review Label Sheet for Emailing"}';
            exit;
        }
    }

    /*
     * SECOND viewing call for labels.  In a sedond window.
     * reads fixutre file, rebuilds sheet and displays
     */
    function labels_pdf()
    {
        Configure::write('debug',0);
        $this->Employee->recursive = 0;
        if (!isset($this->params['url']['fixfile'])) {
            $this->Session->setFlash(__('No employees selected', true));
            $this->redirect(array('controller'=>'employees','action'=>'select_labels'));
        }
        if (isset($this->params['url']['fixfile'])) {
            $xml_home = Configure::read('xml_home');
            $labelsdir = $xml_home.'labels/fixtures';
            $fixfilename=$labelsdir.DS.$this->params['url']['fixfile'];

            $empComp = new EmployeeComponent;
            $pdf = $empComp->build_label_sheet_from_fixture($fixfilename);
            $pdf->Output();
            flush();
            //debug($employees);exit;
        }
    }

    /*
     *  Ajax post call, receives full form, and reads the form sent previously
     */
    function soap_labels_pdf_email()
    {
        Configure::write('debug',0);
        $this->Employee->recursive = 0;
        if (!isset($this->params['form']['fixture-random'])) {
            header('Content-type: application/json');
            echo '{ "result":"1","message":"no fixfile parm mentioned"}';
            exit;
        }
        if (isset($this->params['form']['fixture-random'])) {
            $xml_home = Configure::read('xml_home');
            $labelsdir = $xml_home.'labels/fixtures';
            $fixfilename=$labelsdir.DS.$this->params['form']['fixture-random'];
            $fsize = filesize($fixfilename.'.json');
            $f=fopen($fixfilename.'.json',"r");
            $fixstr = fread($f,$fsize);
            fclose($f);
            // step on $fixob again to get email.
            $fixobj = json_decode ( $fixstr);
            $email = $fixobj->{'user_email'};
            /*
             * rebuild pdf
             */

            $empComp = new EmployeeComponent;
            $pdf = $empComp->soap_build_label_sheet_from_fixture($fixfilename);
            /*
             * send out email
             */
            $this->send_label_sheet_to_staff($email);
            header('Content-type: application/json');
            echo '{ "result":"0","message":"Label sheet mailed to ".$email}';
            exit;
        }
    }

    function soap_employees_labels_pdf_email()
    {
        Configure::write('debug',0);
        $this->Employee->recursive = 0;
        if (!isset($this->params['form']['fixture-random'])) {
            header('Content-type: application/json');
            echo '{ "result":"1","message":"no fixfile parm mentioned"}';
            exit;
        }
        if (isset($this->params['form']['fixture-random'])) {
            $xml_home = Configure::read('xml_home');
            $labelsdir = $xml_home.'labels/fixtures';
            $fixfilename=$labelsdir.DS.$this->params['form']['fixture-random'];
            $fsize = filesize($fixfilename);
            $f=fopen($fixfilename,"r");
            $fixstr = fread($f,$fsize);
            fclose($f);
            // step on $fixob again to get email.
            $fixobj = json_decode ( $fixstr);
            $email = $fixobj->{'user_email'};
            /*
             * rebuild pdf
             */

            $empComp = new EmployeeComponent;
            $pdf = $empComp->soap_build_label_sheet_from_fixture($fixfilename);
            /*
             * send out email
             */
            $this->send_label_sheet_to_staff($email);
            header('Content-type: application/json');
            echo '{ "result":"0","message":"Label sheet mailed to '.$email.'"}';
            exit;
        }
    }
    private function send_label_sheet_to_staff($email)
    {
        $this->Email->to = 'invoicetest@fogtest.com';
        $this->Email->toName = 'Invoice Tester';
        $subject = 'Employee Label Sheet for Printing';
        $this->Email->subject = $subject;
        $this->Email->from         = 'timecards@rocketsredglare.com';
        $this->Email->fromName     = "Rockets Redglare Invoices";
        $this->Email->body = 'This should work better than the browser rendering';

        $empComp = new EmployeeComponent;
        $filename =$empComp->labelSheetFullyQualifiedFilename();;
        $new_name_when_attached=$filename; //optional
        $this->Email->attach($filename, $new_name_when_attached);
        $result = $this->Email->send();
        $this->Email->to = $email;
        $result = $this->Email->send();
    }
    public function beforeRender(){
        parent::BeforeRender();
        $this->set('page_title',$this->page_title);
    }
    public function upInvoiceItem($item_id=null,$mock_invoice_id=null, $next = null) {
        $this->Employee->ClientsContract->ContractsItem->recursive = 0;
        $item = $this->Employee->ClientsContract->ContractsItem->read(null, $this->params['pass'][0]);
        $this->Employee->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Client','Period',),),false);
        $this->Employee->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->Employee->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $contract = $this->Employee->ClientsContract->read(null, $item['ContractsItem']['contract_id']);
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $ITEMS = $this->Employee->ClientsContract->ContractsItem->find('all', array('conditions'=>array('contract_id'=>$item['ContractsItem']['contract_id'],),
            'order'=>array('ContractsItem.ordering'=>'ASC'),
            'fields'=>array('id','ordering')));
        $STACK=array();
        for ( $counter = 0; $counter < count($ITEMS); $counter++) {
            if($ITEMS[$counter]['ContractsItem']['id'] == $item_id and $counter != 0 )
            {
                $prev=array_pop($STACK);
                array_push($STACK, $ITEMS[$counter]['ContractsItem']);
                array_push($STACK, $prev);
            } else
            {
                array_push($STACK, $ITEMS[$counter]['ContractsItem']);
            }
        }

        for ( $counter = 0; $counter < count($STACK); $counter++) {
            $STACK[$counter]['ordering'] = $counter+1;
            $contractItem = array();
            $contractItem = $this->Employee->ClientsContract->ContractsItem->read(null, $STACK[$counter]['id']);
            $this->data['ContractsItem'] = $contractItem['ContractsItem'];
            $this->data['ContractsItem']['ordering'] = $counter+1;
            //debug($contractItem);exit;
            $this->Employee->ClientsContract->ContractsItem->create();
            $this->Employee->ClientsContract->ContractsItem->save($this->data);
        }
        $this->redirect(array('action'=>$next,$mock_invoice_id));
    }
    public function downInvoiceItem($item_id=null,$mock_invoice_id=null, $next = null) {

        $this->Employee->ClientsContract->ContractsItem->recursive = 0;
        $item = $this->Employee->ClientsContract->ContractsItem->read(null, $item_id);
        $this->Employee->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Client','Period',),),false);
        $this->Employee->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->Employee->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $contract = $this->Employee->ClientsContract->read(null, $item['ContractsItem']['contract_id']);
        $this->Employee->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $ITEMS = $this->Employee->ClientsContract->ContractsItem->find('all', array('conditions'=>array('contract_id'=>$item['ContractsItem']['contract_id'],),
            'order'=>array('ContractsItem.ordering'=>'ASC'),
            'fields'=>array('id','ordering')));
        $STACK=array();
        for ( $counter = 0; $counter < count($ITEMS); $counter++) {
            array_push($STACK, $ITEMS[$counter]['ContractsItem']);
            if($ITEMS[$counter]['ContractsItem']['id'] == $item_id and $counter < count($ITEMS)-1 )
            {
                $current=array_pop($STACK);
                array_push($STACK, $ITEMS[$counter+1]['ContractsItem']);
                array_push($STACK, $current);
                $counter++;
            }
        }

        for ( $counter = 0; $counter < count($STACK); $counter++) {
            $contractItem = $this->Employee->ClientsContract->ContractsItem->read(null, $STACK[$counter]['id']);
            $this->data['ContractsItem'] = $contractItem['ContractsItem'];
            $this->data['ContractsItem']['ordering'] = $counter+1;

            $this->Employee->ClientsContract->ContractsItem->create();
            $this->Employee->ClientsContract->ContractsItem->save($this->data);
        }

        $this->redirect(array('action'=>$next,$mock_invoice_id));
    }

    public function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'soap_python_view',
                'soap_python_index',
                'soap_timecard',
                'soap_activeinactive',
                'soap_voided',
                'soap_w4',
                'soap_de34',
                'soap_i9',
                'soap_medical',
                'soap_indust',
                'soap_info',
                'labels_pdf',
                'soap_labels_pdf',
                'soap_payrolls_labels_pdf',
                'soap_employees_labels_pdf_email',
                'soap_labels_pdf_email',
                'sync_sphene_step2',
                'add',
                'add_memo',
                'add_note',
                'edit_memo',
                'edit_note',
                'add_contract',
                'edit_contract',
                'add_notes_payment',
                'edit_invoice',
                'edit_commissions_payment',
                'process_selection',
                'labels_pdf_email',
                'add_contract_comm_item',
                'edit_contract_item_submit',
            ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }

}
