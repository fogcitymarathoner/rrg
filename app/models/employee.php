<?php
/*
 *  Link opening Commissions items to Invoice items and Invoices
 *     `invoices_items_commissions_items` opening = True, ItemId = 0
 *
 * Make sure Employee delete method deletes Invoice and Invoice Item
 *
 * Make sure new Employee fills in OpeningInvoiceID
 *
 *
 */
App::import('Core', 'Security');
App::import('Component', 'Json');
//App::import('Component', 'Xml');
App::import('Component', 'RrgString');
App::import('Component', 'HashUtils');
App::import('Model', 'CommissionsReport');


App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Component', 'Datasources');
App::import('Component', 'Commissions');
App::import('Component', 'FixtureDirectories');





class Employee extends AppModel {
    var $name = 'Employee';
    var $actsAs = array('Cipher' => array('cipher' => array('ssn_crypto','password','bankaccountnumber_crypto', 'bankroutingnumber_crypto')));
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasOne = array(
        'Profile' => array(
            'className' => 'Profile',
            'dependent' => true,
            ),
    );
    var $belongsTo = array(
            'State' => array('className' => 'State',
                                'foreignKey' => 'state_id',
                                'conditions' => '',
                                'fields' => '',
                                'order' => ''
            ),
    );
    var $hasMany = array(
        'ClientsContract' => array('className' => 'ClientsContract',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'EmployeesLetter' => array('className' => 'EmployeesLetter',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'EmployeesMemo' => array('className' => 'EmployeesMemo',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date DESC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'EmployeesPayment' => array('className' => 'EmployeesPayment',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'EmployeesEmail' => array('className' => 'EmployeesEmail',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CommissionsPayment' => array('className' => 'CommissionsPayment',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'NotesPayment' => array('className' => 'NotesPayment',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),

        'Note' => array('className' => 'Note',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'Note.date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),

        'Expense' => array('className' => 'Expense',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'InvoicesItemsCommissionsItem' => array('className' => 'InvoicesItemsCommissionsItem',
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );
    var $validate = array(
            'firstname' => array('notempty'),
            'lastname' => array('notempty'),
            #'city' => array('notempty'),
            'state_id' => array('notempty'),

            'username' => array(
                'rule' => 'isUnique',
                'message' => 'This username has already been taken.'
            ),

            'slug' => array(
                'rule' => 'isUnique',
                'message' => 'This slug has already been taken.'
            ),
            #'zip' => array('notempty'),
            #'ssn' => array('notempty'),
    );

    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;
        $this->xml_home = Configure::read('xml_home');

        parent::__construct();
    }
    function issalesforce($id)
    {
        $pros = $this->Profile->find('all', array(
           'conditions' =>array('employee_id' => $id),
        ));
        if(empty($pros))
            return 0;
        $user = $this->Profile->User->find('all', array(
                   'conditions' =>array('User.id' => $pros[0]['Profile']['user_id']),
                ));
        if($user)
        {
            if($user[0]['User']['group_id']== 2)
            {
                return (1);
            } else
            {
                return (0);
            }
        }
    }
    function activeEmployees()
    {
        $employeesAll = $this->find('all',null);
        $employees = array();
        foreach ($employeesAll as $employee):
            $employees[$employee['Employee']['id']] =
                $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        endforeach;
        return $employees;
    }
    function activeEmployees_cache()
    {
        //$employeesAll = $this->find('all',null);
        $employees = array();

        $this->xml_home = Configure::read('xml_home');
        $fixfilename =    $this->xml_home.'employees/actives.xml';
        $f = fopen($fixfilename,'r');
        $fsize = filesize($fixfilename);
        $doc = fread($f,$fsize);
        fclose($f);

        $userializer = &new XML_Unserializer();
        $userializer->unserialize($doc);
        $employeesActive = $userializer->getUnserializedData ( );

        foreach ($employeesActive as $employee):
            $employees[$employee['Employee']['id']] =
                $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        endforeach;
        return $employees;
    }
    function salesStaff()
    {
            $employeesAll = $this->find('all',array('conditions'=>
                        array(
                                'Employee.salesforce' => 1,
                        )));
            $employees = array();
            foreach ($employeesAll as $employee):
                $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
            endforeach;
            return $employees;
    }
    function completeList()
    {
            $employeesAll = $this->find('all',array('conditions'=>
                        array(
                                'Employee.active' => 1,
                                'Employee.voided'=>0,
                                'Employee.w4'=>1,
                                'Employee.de34'=>1,
                                'Employee.i9'=>1,
                                'Employee.medical'=>1,
                                'Employee.indust'=>1,
                                'Employee.info'=>1
                        )));
            $employeeslist = array();
            foreach ($employeesAll as $employee):
                array_push($employeeslist, $employee['Employee']['id']);
            endforeach;
            return $employeeslist;
    }
    function view_data($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Client','Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Profile->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $employee = $this->read(null, $id);
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        $employee['User']=$employee['Profile']['User'];
        unset($employee['Profile']['User']);
        return($employee);
    }
    function view_notesreport_data($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Client','Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('hasMany' => array('Note','ClientsContract','CommissionsPayment',
                    'NotesPayment','Expense','InvoicesItemsCommissionsItem',
                    'EmployeesLetter','EmployeesMemo','EmployeesPayment','EmployeesEmail',
                    'EmployeesPayment',
                ),),false);
        $employee = $this->read(null, $id);
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }
    function view_notespayment_data($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Client','Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('hasOne' => array('Profile'),),false);
        $employee = $this->read(null, $id);
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }

    function view_contract_data($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Client','Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('belongsTo' => array('State'),),false);
        $this->unbindModel(array('hasOne' => array('Profile'),),false);
        $employee = $this->read(null, $id);
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }


    function view_memo_data($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('belongsTo' => array('Note','State'),),false);
        $this->unbindModel(array('hasOne' => array('Profile'),),false);
        $employee = $this->read(null, $id);
        //debug($employee);exit;
        return($employee);
    }

    function view_notes_data($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('belongsTo' => array('Note','State'),),false);
        $this->unbindModel(array('hasOne' => array('Profile'),),false);
        $employee = $this->read(null, $id);
        //debug($employee);exit;
        return($employee);
    }
    function view_data_payments($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('belongsTo' => array('Note','State'),),false);
        $this->unbindModel(array('hasOne' => array('Profile'),),false);
        $employee = $this->read(null, $id);
        //debug($employee);exit;
        return($employee);
    }
    function view_data_paychecks_due($id)
    {
        //$employee = $this->find('all',array('conditions'=>array('Employee.id'=>1025)));
        //debug($employee[0]['Employee']['id']);
        $employee = $this->view_data_payments($id);
        $duepaychecks =  $this->ClientsContract->Invoice->employee_paychecks_due($id,$employee);
        $count = 0;
        foreach($duepaychecks as $paycheck)
        {
            unset($duepaychecks[$count]['Invoice']);
            $count++;
        }
        $employee['Paychecks'] = $duepaychecks;

        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }
    function view_data_paychecks_paid($id,$employee)
    {
        $employee = $this->view_data_payments($id,$employee);
        $duepaychecks =  $this->ClientsContract->Invoice->employee_paychecks_paid($id,$employee);
        $count = 0;
        foreach($duepaychecks as $paycheck)
        {
            unset($duepaychecks[$count]['Invoice']);
        $duepaychecks[$count]['Paycheck']['display']=1;
            $count++;
        }
        $employee['Paychecks'] = $duepaychecks;
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }
    function view_data_skipped_timecards($id)
    {
        $employee = $this->view_data_payments($id);
        $duepaychecks =  $this->ClientsContract->Invoice->employee_skipped_timecards($id);
        $count = 0;
        foreach($duepaychecks as $paycheck)
        {
            unset($duepaychecks[$count]['Invoice']);
            $count++;
        }
        $employee['Paychecks'] = $duepaychecks;
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }
    function view_data_expenses($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Client','Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->InvoicesItemsCommissionsItem->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->unbindModel(array('hasOne' => array('Profile','InvoicesOpening',),),false);
        $this->unbindModel(array('belongsTo' => array('Note','InvoicesItemsCommissionsItem',),),false);
        $employee = $this->read(null, $id);
        $expense_cats = $this->Expense->ExpensesCategory->find('list');
        $this->Expense->unbindModel(array('belongsTo' => array('Employee','ExpensesCategory'),),false);
        $expenses =  $this->Expense->find('all',
               array('conditions' =>
                    array('employee_id'=> $id,
                        ),
                                'order'=>'date desc'
               )
        );
        $count = 0;
        foreach($expenses as $expense)
        {
            $expenses[$count]['Expense']['category']=$expense_cats[$expense['Expense']['category_id']];
            $count++;
        }
        //debug($expenses);debug($expense_cats);exit;
        $employee['Expenses'] = $expenses;
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        return($employee);
    }
    function new_employee($employee)
    {
        $employee['Employee']['active']=1;
        $employee['Employee']['created_date']=date('Y-m-d');
        $this->create();
        if ($this->save($employee)) {
            if (isset($employee['Employee']['email']) && $employee['Employee']['email'] != null) {
                $employee['EmployeesEmail']['employee_id'] = $this->getLastInsertID();
                $employee['EmployeesEmail']['email'] = $employee['Employee']['email'];
                $this->EmployeesEmail->create();
                $this->EmployeesEmail->save($employee);
            }
            $employeepass=$this->read(null, $this->getLastInsertID());
            # one more save to generate slug and username
            $this->data['Employee'] = $employeepass['Employee'];
            $this->data['Employee']['modified_date'] = date('Y-m-d H:m:s');
            if (isset($employee['Employee']['email']) && $employee['Employee']['email'] != null) {
                $username = $employee['EmployeesEmail']['email'];
                $username_count = $this->find('count',array('conditions'=>array('username like "'.$username.'%"','Employee.id !='.$this->data['Employee']['id'])));
                if($username_count == 0)
                {
                    $this->data['Employee']['username'] = $username;
                }
                else
                {
                    $this->data['Employee']['username'] = $username.(string)($username_count);
                }
            }
            $slug = strtolower (str_replace (' ','',preg_replace('/[^a-zA-Z0-9\s]/', '', $this->data['Employee']['firstname']).'-'.preg_replace('/[^a-zA-Z0-9\s]/', '', $this->data['Employee']['lastname']).'-'.$this->data['Employee']['id']));
            $this->data['Employee']['slug'] = $slug;

            if(isset($employee['Employee']['firstname']))
                $this->data['Employee']['firstname'] =strtoupper($employee['Employee']['firstname']);
            if(isset($employee['Employee']['lastname']))
                $this->data['Employee']['lastname'] =strtoupper($employee['Employee']['lastname']);
            if(isset($employee['Employee']['nickname']))
                $this->data['Employee']['nickname'] =strtoupper($employee['Employee']['nickname']);
            if(isset($employee['Employee']['street1']))
                $this->data['Employee']['street1'] =strtoupper($employee['Employee']['street1']);
            if(isset($employee['Employee']['street2']))
                $this->data['Employee']['street2'] =strtoupper($employee['Employee']['street2']);
            if(isset($employee['Employee']['city']))
                $this->data['Employee']['city'] =strtoupper($employee['Employee']['city']);
            $this->save($this->data);
            $employeepass=$this->read(null, $employeepass['Employee']['id']);
            $this->data['Profile'] = array();
            $this->data['User'] = array();
            if (isset($employeepass['Employee']['email']) && $employeepass['Employee']['email'] != null) {
                $username = $employeepass['EmployeesEmail']['email'];
                $username_count = $this->find('count',array('conditions'=>array('username like "'.$username.'%"','Employee.id !='.$employeepass['Employee']['id'])));
                if($username_count == 0)
                {
                    $this->data['Employee']['username'] = $username;
                }
                else
                {
                    $this->data['Employee']['username'] = $username.(string)($username_count);
                }
            }
            $this->data['User']['firstname'] = $employeepass['Employee']['firstname'];
            $this->data['User']['lastname'] = $employeepass['Employee']['lastname'];
            if (isset($employee['Employee']['email']) && $employee['Employee']['email'] != null) {
                $this->data['User']['email'] = $employee['EmployeesEmail']['email'];
            }
            $this->data['User']['created_user'] = $employeepass['Employee']['created_user_id'];
            $this->data['User']['modified_user'] = $employeepass['Employee']['created_user_id'];
            $this->data['User']['created_date'] = date('Y-m-d');
            $this->data['User']['modified_date'] = date('Y-m-d H:m:s');
            $this->data['User']['active'] = 1;
            $this->data['User']['group'] = 3;
            $password = 'password';
            $this->data['User']['password_confirm'] = $password;
            $this->data['User']['password'] = Security::hash(Configure::read('Security.salt') . $password);
            $this->Profile->User->save($this->data);
            $this->data['Profile']['employee_id'] = $employeepass['Employee']['id'];
            $this->data['Profile']['user_id'] = $this->Profile->User->getLastInsertID();
        }
        return($this->getLastInsertID());
    }
    function active_jumpto_menu()
    {
        $employeesMenu = array();
        $this->unbindModel(array('belongsTo' => array(
                                                    'Note',
                                                    'State',
                                                    'InvoicesItemsCommissionsItem',
                                                ),),false);
        $this->unbindModel(array('hasMany' => array(
                                                    'ClientsContract',
                                                    'EmployeesMemo',
                                                    'EmployeesPayment',
                                                    'EmployeesEmail',
                                                    'EmployeesPayment',
                                                    'CommissionsPayment',
                                                    'NotesPayment',
                                                    'Note',
                                                    'Expense',
                            ),),false);
        $employees = $this->find('all',array('conditions'=>array(
                                                    'active'=>1,
                                                ),
                                        'order'=> array('firstname'=>'ASC', 'lastname'=> 'ASC'),
                                        ));
        foreach ($employees as $employee)
        {
            $employeesMenu[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        }
        return $employeesMenu;
    }
    function employeeforcontractbuild($id)
    {
        $this->unbindModel(array('belongsTo' =>
                                            array('Note',
                                                    'State',
                                                    'InvoicesItemsCommissionsItem',
                                            ),),false);
        $this->unbindModel(array('hasMany' =>
                                            array('Note',
                                                    'InvoicesItemsCommissionsItem',
                                                    'ClientsContract',
                                                    'EmployeesMemo',
                                                    'EmployeesPayment',
                                                    'EmployeesEmail',
                                                    'CommissionsPayment',
                                                    'NotesPayment',
                                                    'Expense',
                                            ),),false);
        //debug($this->read(null, $id));exit;
        return $this->read(null, $id);
    }
    function commissionIncrease($taggedreport, $employee)
    {
        $increase = 0;
        foreach ($taggedreport['InvoicesItemsCommissionsItem'] as $invcommitem):
            if( $invcommitem['voided']!=1)
            {
                $increase = $increase+$invcommitem['amount'];
            }
        endforeach;

        return ($increase);
    }
    function commissionDecrease($taggedreport)
    {
        $decrease = 0;
        foreach ($taggedreport['CommissionsPayment'] as $payment):
            //debug($payment);exit;
            if($payment['voided']!=1)
                $decrease = $decrease+$payment['amount'];
        endforeach;
        return ($decrease);
    }
    function noteIncrease($taggedreport,$employee)
    {
        $increase = 0;
        foreach ($taggedreport['Note'] as $invcommitem):
            if( $invcommitem['voided']!=1)
            {
                $increase = $increase+$invcommitem['amount'];
            }

        endforeach;
        return ($increase);
    }
    function noteDecrease($taggedreport)
    {
        $decrease = 0;
        foreach ($taggedreport['NotesPayment'] as $payment):
            //debug($payment);exit;
            if($payment['voided']!=1)
                $decrease = $decrease+$payment['amount'];
        endforeach;
        return ($decrease);
    }
    function removetaggedreportsemployee($employee_id)
    {

        $this->recursive = 2;

        $employee = $this->read(null, $employee_id); //debug($employee); exit;
    }
    function strikecount($id)
    {
        $this->recursive = 1;
        $this->unbindModel(array('belongsTo' => array('State'),),false);
        $this->unbindModel(array('hasOne' => array('Profile'),),false);
        $emp = $this->read(null, $id);
        $strike = 0;
        if(!$emp['Employee']['dob'])
            $strike++;
        if(!$emp['Employee']['startdate'])
            $strike++;
        if(!$emp['Employee']['street1'])
            $strike++;
        if(!$emp['Employee']['city'])
            $strike++;
        if(!$emp['Employee']['zip'])
            $strike++;
        if($emp['Employee']['usworkstatus']==0)
            $strike++;
        if($emp['Employee']['tcard']==0)
            $strike++;
        if($emp['Employee']['w4']==0)
            $strike++;
        if($emp['Employee']['de34']==0)
            $strike++;
        if($emp['Employee']['i9']==0)
            $strike++;
        if($emp['Employee']['medical']==0)
            $strike++;
        if($emp['Employee']['indust']==0)
            $strike++;
        if($emp['Employee']['info']==0)
            $strike++;
        $strike_max = 13;
        $strike = 13 - $strike;
        return(round(($strike/$strike_max)*100,0));
    }
    function add_employee_user_profile($emp, $msg)
    {
        Configure::write('debug', 2);
        $emp['Employee']['modified_date'] = date('Y-m-d H:m:s');
        $emp['Employee']['created_date'] = date('Y-m-d H:m:s');
        if(isset($emp['Employee']['firstname']))
        {
            $emp['Employee']['firstname'] = str_replace(' ','',$emp['Employee']['firstname']);
            $emp['Employee']['firstname']= strtoupper ( $emp['Employee']['firstname']);
        }
        if(isset($emp['Employee']['lastname']))
        {
            $emp['Employee']['lastname']= strtoupper ( $emp['Employee']['lastname']);
            $emp['Employee']['lastname'] = str_replace(' ','',$emp['Employee']['lastname']);
        }
        if(isset($emp['Employee']['street1']))
            $emp['Employee']['street1']= strtoupper ( $emp['Employee']['street1']);
        if(isset($emp['Employee']['street2']))
            $emp['Employee']['street2']= strtoupper ( $emp['Employee']['street2']);
        if(isset($emp['Employee']['city']))
            $emp['Employee']['city']= strtoupper ( $emp['Employee']['city']);
        $emp['Employee']['active']=1;
        $emp['Employee']['created_date']=date('Y-m-d');
        $rrgS = new RrgStringComponent();

        if (isset($emp['Employee']['email']) && $emp['Employee']['email'] != null) {
            $username = $emp['Employee']['email'];
            // removed this condition
            $username_count = $this->find('count',array('conditions'=>array('username like "'.$username.'%"')));
            if($username_count == 0)
            {
                $this->data['Employee']['username'] = $username;
            }
            else
            {
                $this->data['Employee']['username'] = $username.(string)($username_count);
            }
        }else{
            $emp['Employee']['username']=$rrgS->rand_string(10);
        }
        $emp['Employee']['slug']=$rrgS->rand_string(10);

        if ($this->save($emp)) {
            $msg .= 'employee saved';
            $emp['Employee']['id']= $this->getLastInsertID();
            if (isset($emp['Employee']['email']) && $emp['Employee']['email'] != null) {
                $emp['EmployeesEmail']['employee_id'] = $emp['Employee']['id'];
                $emp['EmployeesEmail']['email'] = $emp['Employee']['email'];
                $this->EmployeesEmail->create();
                $this->EmployeesEmail->save($emp);

                $msg .= 'employee email saved';
            }
            $newEmpID = $this->getLastInsertID();
            $employeepass=$this->read(null, $newEmpID);
            $emp['Employee']['modified_date'] = date('Y-m-d H:m:s');
            if (isset($emp['Employee']['firstname']) && isset($emp['Employee']['lastname'])&& isset($emp['Employee']['id']))
            {
                $slug = strtolower (str_replace (' ','',preg_replace('/[^a-zA-Z0-9\s]/', '', $emp['Employee']['firstname']).'-'.preg_replace('/[^a-zA-Z0-9\s]/', '', $emp['Employee']['lastname']).'-'.$emp['Employee']['id']));
                $emp['Employee']['slug'] = $slug;
            }

            $msg .= 'employee saved again with slug';
            $this->save($emp);
            $emp['Profile'] = array();
            $emp['User'] = array();
            $emp['User']['username'] = $emp['Employee']['username'];
            $emp['User']['firstname'] = $emp['Employee']['firstname'];
            $emp['User']['lastname'] = $emp['Employee']['lastname'];
            if (isset($emp['Employee']['email']) && $emp['Employee']['email'] != null) {
                $emp['User']['email'] = $emp['EmployeesEmail']['email'];
            }
            $emp['User']['created_user'] = $emp['Employee']['created_user_id'];
            $emp['User']['modified_user'] = $emp['Employee']['created_user_id'];
            $emp['User']['created_date'] = date('Y-m-d');
            $emp['User']['modified_date'] = date('Y-m-d H:m:s');
            $emp['User']['active'] = 1;
            $emp['User']['group'] = 3;
            $password = 'password';
            $emp['User']['password_confirm'] = $password;
            $emp['User']['password'] = Security::hash(Configure::read('Security.salt') . $password);
            if($this->Profile->User->save($emp))
            {

                $msg .= 'user created ';
                $emp['msg'][] = 'User create successful';
                ;
            } else {
                $emp['msg'][] = 'User create not successful';
                ;
            }
            $emp['Profile']['employee_id'] = $emp['Employee']['id'];
            $emp['Profile']['user_id'] = $this->Profile->User->getLastInsertID();

            if($this->Profile->save($emp))
            {

                $msg .= 'profile saved';
                $emp['msg'][] ='Profile create successful';
                ;
            } else {
                $emp['msg'][] = 'Profile create not successful';
                ;
            }
            $email['employee_id'] = $emp['Employee']['id'];
            if (isset($emp['Employee']['email']) && $emp['Employee']['email'] != null) {
                $email['email'] = $emp['Employee']['email'];
            }
            $emp['EmployeesEmail'] = $email;
            if($this->EmployeesEmail->save($emp))
            {
                $emp['msg'][] ='The Employee Email has been saved<br>';
            } else {
                $emp['msg'][] ='The Employee Email has NOT been saved<br>';
            }
            $this->save($emp);
        } else {
            debug('did not save');
        }
        return (array($emp,$msg));
    }

    /*
     * Write fixture down mark employee as synced
     */
    private function sync($employee,$fixfilename,$serializer)
    {
        if($f = fopen($fixfilename,'w'))
        {
            $employee = $this->zero_out_null($employee);
            fwrite($f, $serializer->serialize($employee));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $empsave = array();
        $empsave['Employee'] = $employee;
        $empsave['Employee']['Employee']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($empsave['Employee']);
    }

    function view_paymentdata($id)
    {
        $this->recursive = 2;
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Client','Employee','Vendor','Invoice','ContractsItem','ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Period'),),false);
        $this->EmployeesMemo->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array('Employee','Payroll','Invoice'),),false);
        $this->EmployeesEmail->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Note->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->Profile->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $this->NotesPayment->unbindModel(array('belongsTo' => array('Employee'),),false);
        $employee = $this->read(null, $id);
        $employee['Employee']['issalesforce'] =  $this->issalesforce($id);
        $employee['User']=$employee['Profile']['User'];
        unset($employee['Profile']['User']);
        return($employee);
    }


}
if(!class_exists('Employee'))
{

}
?>
