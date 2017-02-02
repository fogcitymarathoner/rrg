<?php


class ClientsController extends AppController {
    public function __construct() {

        parent::__construct();
    }
    private function setup_index()
    {
        /*
         * setup view dictionary for index view
         */
        $this->Client->recursive = 0;
        $clients = $this->Client->find('all', array('order'=>array('Client.name ASC')));
        $this->set('clients', $clients);
        $this->page_title = 'Clients';
    }

    private function setup_view_invoices_pending($id)
    {
        // sets up view variables for view_invoices_pending view
        $this->data = $this->Client->invoices_pending($id);
        $this->page_title = $this->data['Client']['name'].' invoices pending';
        $next = 'view_invoices_pending';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->set('state',$client['State']);
    }
    private function setup_view_invoices_open($id)
    {
        $this->page_title = 'Open Invoices Report';

        $fixfile = $this->Datasources->client_open_invoices_file($id);
        if(file_exists ($fixfile))
        {
            $f = fopen($fixfile,'r');
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_open_statement_view($id, $fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            debug($fixfile.' no fix file');

        }
        $next = 'view_invoices_pastdue';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->set('fixfile',$fixfile);

        $this->page_title = $client['Client']['name'].' pastdue invoices';
    }
    private function setup_view_invoices_pastdue($id)
    {
        $this->page_title = 'Pastdue Invoices Report';

        $fixfile = $this->Datasources->client_open_invoices_file($id);
        if(file_exists ($fixfile))
        {
            $f = fopen($fixfile,'r');
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_open_statement_view($id, $fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            debug($fixfile.' no fix file');exit;
            $this->Session->setFlash(__($fixfile.' XML file missing.', true));
        }
        $next = 'view_invoices_pastdue';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->set('fixfile',$fixfile);

        $this->page_title = $client['Client']['name'].' pastdue invoices';
    }
    private function setup_contracts_view($id)
    {
        $contracts = $this->Client->contracts($id);
        $contracts['Client']['id'] = $id;
        $countA = 0;
        foreach ($contracts['ClientsContract'] as $con)
        {
            if($con['active'])
                $countA++;
        }
        $this->page_title = $contracts['Client']['name'].'<br> '.$countA.' active contracts';
        $next = 'view_active_contracts';
        $active = 1;

        $this->data = $this->Client->general_info($id);
        $this->set('client',$this->data['Client']);
        $this->set(compact('next', 'active','contracts'));
    }

    private function prepare_statement_view($id, $fixfile)
    {
        $items = $this->Statements->generate_statement($id);
        $this->set(compact('items'));
        $runtime = $this->Statements->statement_fixture_generation_date($id);
        $this->set(compact('runtime'));
    }
    private function prepare_open_statement_view($id, $fixfile)
    {
        $items = $this->Statements->generate_opens_statement($id, $fixfile);
        $this->set(compact('items'));
        $runtime = $this->Statements->statement_fixture_generation_date($id);
        $this->set(compact('runtime'));
    }

    private function save_contract ($contract, $user)
    {
        $contract['ClientsContract']['created_date'] = date('Y-m-d');
        $contract['ClientsContract']['active'] = 1;
        $contract['ClientsContract']['success'] = 1;
        if ($this->Client->ClientsContract->add($this->data)) {
            $this->Session->setFlash(__('The Contract has been saved', true));

            $contract_id = $this->Client->ClientsContract->getLastInsertID();
            $contract['ClientsContract']['id']= $contract_id;
            #  add monica and invoice testers to email recipients list
            $this->data['User'][]= 12;
            $this->data['User'][]= 13;
            $this->Client->ClientsContract->save($contract);

        } else {
            $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
            $contract['ClientsContract']['success'] = 0;
            /*
            $this->Client->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
            $this->Client->ClientsContract->Employee->unbindModel(array('belongsTo' => array('State'),),false);

            $employeesAll = $this->Client->ClientsContract->Employee->find('all',array('conditions'=>array('active'=>1)));
            $employees = array();
            foreach ($employeesAll as $employee):
                $employees[$employee['Employee']['id']] = $employee['Employee']['id'];
                $employees[$employee['Employee']['name']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
            endforeach;
            $periods = $this->Client->ClientsContract->Period->find('list');
            $this->set(compact('employees', 'clients', 'states', 'periods'));
            */
        }
        return $contract;
    }
    private function add_contract_setup_view($client_id,$step,$employee_id = null)
    {

        if ($client_id == null)
        {
            $this->Session->setFlash(__('Bad Client ID', true));
            $this->redirect(array('action'=>'index'));
        } else
        {
            if($step==1)
            {
                $this->data['ClientsContract']['client_id'] = $client_id;
                $step = 1;
                $employeesMenu = $this->Client->ClientsContract->Employee->active_jumpto_menu();
                $this->set(compact('employeesMenu','step'));
                $client = $this->Client->clientforcontractbuild($client_id);
                $this->data['ClientsContract']['client_name'] = $client['Client']['name'];
                $this->data['ClientsContract']['terms'] = $client['Client']['terms'];
                $this->page_title = $client['Client']['name'].' add contract step 1 of 2';
            }
            else
            {
                $periods = $this->Client->ClientsContract->Period->find('list');
                $clientdata = $this->Client->clientforcontractbuild($client_id);
                $employee = $this->Client->ClientsContract->Employee->employeeforcontractbuild($employee_id);
                $this->set(compact('periods','step','employee','clientdata'));
                $this->data['ClientsContract']['client_name'] = $clientdata['Client']['name'];
                $this->data['ClientsContract']['terms'] = $clientdata['Client']['terms'];
                $this->data['ClientsContract']['client_id'] = $client_id;
                $this->data['ClientsContract']['employee_id'] = $employee_id;
                $this->page_title = $clientdata['Client']['name'].' add contract step 2 of 2';
            }
        }
    }

    private function directLaborCost($id = null) {
        $this->Client->ClientsContract->Invoice->recursive = 1;
        $invoice = $this->Client->ClientsContract->Invoice->read(null, $id);
        $DLR = 0;
        foreach ($invoice['InvoicesItem'] as $invoiceItem):
            $DLR += $invoiceItem['quantity']*$invoiceItem['cost'];
        endforeach;
        return ($DLR);
    }
    public function index() {
        $this->setup_index();

    }
    public function m_index() {
        $this->layout = "default_jqmobile";
        if (!empty($this->data)) {
            if($this->data['name']!=''  )
            {
                $clients = $this->Client->query ('select Client.name,  Client.street1, Client.street2, '.
                    'Client.id, Client.city, Client.zip, '.
                    ' st.post_ab '.
                    ' from clients as Client '.
                    ' left join states as st on Client.state_id=st.id '.
                    ' where Client.name like "%'.$this->data['name'].'%" '.

                    ' order by Client.name ASC');
                $this->set('clients', $clients);
            }
        } else
        {
            $clients = $this->Client->query ('select Client.name, Client.street1, Client.street2, '.
                'Client.id, Client.city, Client.zip, '.
                ' st.post_ab '.
                ' from clients as Client '.
                ' left join states as st on Client.state_id=st.id '.
                ' where Client.active = 1 '.
                ' order by Client.name ASC');
            $this->set('clients', $clients);
            $this->set('completelist', $this->Client->completeList());
        }
        $this->page_title = 'Employees';
    }
    # view broken apart because of memory overflow in view
    public function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->general_info($id);
        $this->set('client',$this->data['Client']);
        $this->page_title = $this->data['Client']['name'].' details';
    }
    public function m_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->general_info($id);
        $this->page_title = $this->data['Client']['name'].' details';
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/view');
    }
    public function m_contracts($id = null) {
        //debug($this->params);exit;
        if(isset($this->params['pass'][0]))
        {
            if ($this->params['pass'][0]>0)
            {
                $this->setup_contracts_view($id);
                $this->layout = "default_jqmobile";
                $this->render('/clients/m/contracts');
            }
        }
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->setup_contracts_view($id);
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/contracts');
    }
    public function view_active_contracts_action($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->setup_contracts_view($id);
    }
    public function view_active_contracts_action_ytd($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->contracts_ytd($id);
        $this->page_title = $this->data['Client']['name'].' active contracts';
        $next = 'view_active_contracts';
        $active = 1;

        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->set(compact('next', 'active'));
    }
    public function view_active_contracts($id = null) {
        $this->view_active_contracts_action($id);

    }
    public function view_active_contracts_printable($id = null) {
        $this->layout = 'print';
        $this->view_active_contracts_action($id);
    }
    public function view_active_contracts_printable_ytd($id = null) {
        $this->layout = 'print';
        $this->view_active_contracts_action_ytd($id);
    }
    public function view_active_contracts_pending_printable($id = null) {
        $this->layout = 'print';
        $this->view_active_contracts_action($id);
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
    }
    public function view_inactive_contracts($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->contracts_inactive($id);

        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $countI = 0;
        foreach($this->data['ClientsContract'] as $con)
        {
            if(!$con['ClientsContract']['active'])
                $countI++;
        }
        $this->page_title = $client['Client']['name'].'<br> '.$countI.' inactive contracts';
        $next = 'view_inactive_contracts';
        $this->set(compact('next', 'active','clientdata'));

    }
    public function view_managers($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->managers($id);
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->page_title = $this->data['Client']['name'].' managers';
    }
    public function m_view_managers($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->managers($id);
        $this->set('clientD',$this->data['Client']);
        $this->page_title = $this->data['Client']['name'].' managers';

        $this->layout = "default_jqmobile";
        $this->render('/clients/m/view_managers');
    }
    public function view_memos($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->memos($id);
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->page_title = $client['Client']['name'].' memos';
    }
    public function view_active_searches($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->searches($id);

        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->page_title = $this->data['Client']['name'].' active searches';
    }
    public function view_inactive_searches($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->searches($id);
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->page_title = $this->data['Client']['name'].' inactive searches';
    }
    public function view_invoice($invoice_id = null)
    {
        /*
         * only accessed  from past due???
         */
        if(isset($this->params['pass'][0]))
        {
            $this->data = $this->Client->ClientsContract->Invoice->getInvoiceReview($invoice_id);
            $this->page_title = 'Edit Invoice: '.$this->data['Invoice']['id'].'-'.$this->data['Client']['Client']['name'].' - '.$this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'];

        } else {

            $this->setup_index();
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this -> render('index');
        }

    }
    public function view_openinginvoices($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->opening_invoices($id);
        $this->page_title = $this->data['Client']['name'].' opening invoices';
        $next = 'view_openinginvoices';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->data['Client'] = $client['Client'];
    }

    public function view_invoices($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->setup_view_invoices_open($id);
    }
    public function view_invoicesDELETE($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        if($this->Statements->client_fixture_file_exists($id))
        {
            if(filesize($this->Datasources->client_statement_file($id)))
            {
                $items = $this->Statements->generate_statement($id);
                $this->set(compact('items'));
                $runtime = $this->Statements->statement_fixture_generation_date($id);
                $this->set(compact('runtime'));
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }

        } else
        {
            debug('no fix file ');echo $this->Datasources->client_statement_file($id); exit;
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->data = $this->Client->read(null,$id);
        $this->page_title = $this->data['Client']['name'].' open invoices';
        $next = 'view_invoices';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
    }
    public function view_invoices_print($id = null) {
        $this->layout='print';
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $statementdir = $this->xml_home.'clients/statements/';
        $fixfile = $statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($fixfile))
        {
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $items = $this->Statements->generate_statement($id);
                $this->set(compact('items'));
                $runtime = $this->Statements->statement_fixture_generation_date($id);
                $this->set(compact('runtime'));
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->data = $this->Client->read(null,$id);
        $this->page_title = $this->data['Client']['name'].' open invoices';
        $next = 'view_invoices';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
    }
    public function view_statement($id = null) {
        $this->data['Client']= array();
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $clientdir = $this->xml_home.'clients/';
        $clfile = $clientdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($clfile))
        {
            $fsize = filesize($clfile);
            if($fsize)
            {
                $client = $this->Client->get_cached_client($clfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            echo 'Client reports not generated yet';exit;
        }
        $statementdir = $this->xml_home.'clients/statements/';
        $fixfile = $statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($fixfile))
        {
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_statement_view($id,$fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }

        } else
        {
            debug('no fix file');debug($fixfile);exit;
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->page_title = $client['name'].' statement';
        $next = 'view_statement';
        $this->set(compact('next','client'));
    }
    public function m_view_statement($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $clientdir = $this->xml_home.'clients/';
        $clfile = $clientdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($clfile))
        {
            $fsize = filesize($clfile);
            if($fsize)
            {
                $client = $this->Client->get_cached_client($clfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            echo 'Client reports not generated yet';exit;
        }
        $statementdir = $this->xml_home.'clients/statements/';
        $fixfile = $statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($fixfile))
        {
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_statement_view($id,$fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }

        } else
        {
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->layout = "default_jqmobile";
        $this->set('client',$client);
        $this->data['Client']['id'] = $id;
        $this->page_title = $client['name'].' statement';
    }
    public function view_statement_print($id = null) {
        $this->layout='print';
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $clientdir = $this->xml_home.'clients/';
        $clfile = $clientdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($clfile))
        {
            $fsize = filesize($clfile);
            if($fsize)
            {
                $client = $this->Client->get_cached_client($clfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            echo 'Client reports not generated yet';exit;
        }
        $statementdir = $this->xml_home.'clients/statements/';
        $fixfile = $statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        $this->page_title = ' statement';
        if(file_exists ($fixfile))
        {
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_statement_view($id,$fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }
        } else
        {
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->page_title = $client['name'].' statement';
        $next = 'view_statement';
        $this->set(compact('next','client'));
    }
    public function view_payment_history($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $statementdir = $this->xml_home.'clients/statements/';
        $fixfile = $statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($fixfile))
        {
            $f = fopen($fixfile,'r');
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_statement_view($id, $fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }

        } else
        {
            debug('no fix file');exit;
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->data['Client']['id'] = $id;
        $client = $this->Client->general_info($id);
        $this->page_title = $client['Client']['name'].' statement';
        $next = 'view_statement';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('fixfile',$fixfile);
        $this->set('client',$client['Client']);
        $this->set('state',$client['State']['name']);
    }

    public function view_payment_history_print($id = null) {
        $this->layout='print';
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $statementdir = $this->xml_home.'clients/statements/';
        $fixfile = $statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        if(file_exists ($fixfile))
        {
            $f = fopen($fixfile,'r');
            $fsize = filesize($fixfile);
            if($fsize)
            {
                $this->prepare_statement_view($id,$fixfile);
            }else
            {
                $this->Session->setFlash(__('XML file is empty.', true));
            }

        } else
        {
            debug('no fix file');exit;
            $this->Session->setFlash(__('XML file missing.', true));
        }
        $this->data['Client']['id'] = $id;
        $client = $this->Client->general_info($id);
        $this->page_title = $client['Client']['name'].' statement';
        $next = 'view_statement';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('client',$client['Client']);
        $this->set('state',$client['State']['name']);
    }
    public function view_invoices_pastdue($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->page_title = ' pastdue invoices';
        $this->setup_view_invoices_pastdue($id);
    }
    public function view_invoices_pastdue_print($id = null) {

        $this->layout='print';
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->page_title = ' pastdue invoices - Printer Friendly';


        $this->setup_view_invoices_pastdue($id);
    }
    public function m_view_invoices_pastdue($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }

        $this->page_title = 'Pastdue Invoices Report';

        $this->setup_view_invoices_pastdue($id);
        $this->layout = "default_jqmobile";
        $next = 'view_invoices_pastdue';
        $this->set(compact('next'));
        $client = $this->Client->general_info($id);
        $this->set('clientD',$client['Client']);
    }
    public function view_invoices_pending($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->setup_view_invoices_pending($id);
    }

    public function m_view_invoices_pending($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->invoices_pending($id);
        $this->page_title = $this->data['Client']['name'].' invoices pending';
        $next = 'view_invoices_pending';
        $this->set(compact('next'));
        $this->layout = "default_jqmobile";

        $this->set('state',$this->data['State']['name']);
        $this->render('/clients/m/view_invoices_pending');
    }
    private function setup_clients_checks_view($id)
    {

        $this->data = $this->Client->checks($id);
        $this->page_title = $this->data['Client']['name'].' checks';
        $client = $this->Client->general_info($id);
        $this->data['Client'] = $client['Client'];
        $next = 'view_checks';
        $this->set(compact('next'));
    }
    public function view_checks($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->setup_clients_checks_view($id);
    }
    public function view_checks_print($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->layout = 'print';

        $this->setup_clients_checks_view($id);
    }
    public function m_view_checks($id = null) {
        $this->layout = "default_jqmobile";
        if (!$id) {
            $this->Session->setFlash(__('Invalid Client.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->data = $this->Client->checks($id);
        $this->page_title = $this->data['Client']['name'].' checks';
        $next = 'view_checks';
        $this->set(compact('next'));
    }
    public function view_check($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Check.', true));
            $this->redirect(array('action'=>'index'));
        }
        $next = 'view_check';
        $clientsCheck = $this->Client->ClientsCheck->checkforpaymentreview($id);
        $client = $this->Client->clientforcontractbuild($clientsCheck['ClientsCheck']['client_id']);
        $this->set(compact('clientsCheck','next'));
        $this->page_title = $client['Client']['name'].' check #'.$clientsCheck['ClientsCheck']['number'];
    }
    public function view_contract($id = null) {
        $id = $this->params['pass'][0];
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 1;
        $this->Client->unbindModel(array('hasMany' => array(
            'Invoice',
            'ClientsManager'
        ),),false);
        $this->Client->ClientsContract->unbindModel(array('hasMany' => array(
            'Invoice',
            'ContractsItem',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
            'ClientsManager'
        ),),false);
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $client = $this->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Client->ClientsContract->Invoice->find('all', array('conditions'=>array(
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
        $this->set(compact('hours'));
        $this->page_title = 'View '.$client['Client']['name'].' contract general info - '.$clientsContract['ClientsContract']['title'];
        $next = 'view_contract';
        $this->set(compact('next'));
    }

    public function m_view_contract($id = null) {
        $id = $this->params['pass'][0];
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 1;
        $this->Client->unbindModel(array('hasMany' => array(
            'Invoice',
            'ClientsManager'
        ),),false);
        $this->Client->ClientsContract->unbindModel(array('hasMany' => array(
            'Invoice',
            'ContractsItem',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
            'ClientsManager'
        ),),false);
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $client = $this->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Client->ClientsContract->Invoice->find('all', array('conditions'=>array(
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
        $this->set(compact('hours'));
        $this->page_title = 'View '.$client['Client']['name'].' contract general info - '.$clientsContract['ClientsContract']['title'];
        $next = 'view_contract';
        $this->set(compact('next'));
        $client = $this->Client->general_info($client['Client']['id']);
        $this->set('clientD',$client);
        /*
         * Refactor above, below is specific to mobile app
         */
        /*
        $this->Client->ClientsContract->recursive = 1;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        */
        $this->Client->ClientsContract->ContractsItem->recursive=2;
        $this->Client->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Client->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$id,
        ),
            'order'=>'ordering ASC'
        ));
        $next = 'view_contract_items';
        $this->set(compact('items','next'));

        $this->layout = "default_jqmobile";
        $this->render('/clients/m/view_contract');
    }
    public function view_contract_items($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 1;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        $this->Client->ClientsContract->ContractsItem->recursive=2;
        $this->Client->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Client->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
        ),
            'order'=>'ordering ASC'
        ));

        $next = 'view_contract_items';
        $this->set(compact('items','next'));

        $client = $this->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->set('client', $client);
        $this->page_title = 'View '.$client['Client']['name'].' contract billable items - '.$clientsContract['ClientsContract']['title'];
    }
    public function view_contract_invoices($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 1;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Client->ClientsContract->Invoice->find('all', array('conditions'=>array(
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
        $client = $this->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->set('client', $client);
        $this->set(compact('invoices','hours'));
        $this->page_title = 'View '.$clientsContract['Client']['name'].' contract invoices - '.$clientsContract['ClientsContract']['title'];
    }
    public function view_contract_emails($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 1;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Client->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $this->Client->ClientsContract->ContractsItem->recursive=2;
        $this->Client->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Client->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
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
        $client = $this->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->set('client', $client);
        $this->set(compact('invoices','hours'));
        $this->page_title = 'View '.$client['Client']['name'].' contract invoice email recipients - '.$clientsContract['ClientsContract']['title'];
    }
    public function view_contract_invoice_details($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 1;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
    }
    public function view_invoice_pdf($id,$display= null)
    {
        $this->Client->ClientsContract->Invoice->generatepdf($id,1,$this->xml_home);
        $this->redirect(array('action'=>'edit_invoice/2/'.$id));
    }

    public function m_view_invoice_pdf($id,$display= null)
    {
        $this->Client->ClientsContract->Invoice->generatepdf($id,1,$this->xml_home);
        $this->redirect(array('action'=>'edit_invoice/2/'.$id));
    }
    public function view_invoices_item($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid InvoicesItem.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('invoicesItem', $this->Client->ClientsContract->Invoice->InvoicesItem->read(null, $id));
    }
    public function view_mock_invoice($id = null)
    {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }
        $clientsContract = $this->Client->ClientsContract->clientcontract_mock_invoice_manage($id);
        $this ->Client->ClientsContract->Invoice-> fixmockinvoice($clientsContract['ClientsContract']['mock_invoice_id'],$clientsContract,$this->webroot );
        $clientsContract = $this->Client->ClientsContract->clientcontract_mock_invoice_manage($id);
        $this->Client->ClientsContract->ContractsItem->recursive=2;
        $this->Client->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Client->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
        ),'order'=>'ordering asc'));
        $this->set(compact('items'));
        $employee =  $this->Client->ClientsContract->Invoice->employeeForInvoicing($clientsContract['ClientsContract']['employee_id']);
        $this->data = $this->Client->ClientsContract->Invoice->read(null, $clientsContract['ClientsContract']['mock_invoice_id']);

        $subject =  $this->InvoiceFunction->email_subject($this->data, $employee);


        $invoice = $this->Client->ClientsContract->Invoice->read(Null,$clientsContract['ClientsContract']['mock_invoice_id']);
        $this->data['Invoice'] =  $invoice['Invoice'];

        $invoiceurltoken = $this->InvoiceFunction->invoiceTokenUrl($this->data, $subject, $this->webroot, $employee);

        $this->data['Invoice']['urltoken'] = $invoiceurltoken;
        $next = 'view_mock_invoice';
        $this->set(compact('next'));
        $this->set('clientsContract', $clientsContract);
        $client = $this->Client->general_info($clientsContract['ClientsContract']['client_id']);
        $this->set('client', $client);
        $this->page_title = 'View '.$client['Client']['name'].' contract mock invoice - '.$clientsContract['ClientsContract']['title'];
    }
    public function add() {
        if (!empty($this->data)) {
            $this->Client->create();
            $this->data['Client']['created_date'] = date('Y-m-d');
            $this->data['Client']['active'] = 1;
            $user = $this->Auth->user();
            $this->data['Client']['created_user_id'] =$user['User']['id'];
            $this->data['Client']['modified_user_id'] =$user['User']['id'];
            $this->data['Client']['modified_date'] = date('Y-m-d');
            if ($this->Client->save($this->data)) {
                $this->Session->setFlash(__('The Client has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Client could not be saved. Please, try again.', true));
            }
        }
        $states = $this->Client->State->find('list');
        $this->set(compact('states'));
        $this->page_title = 'Add New Client';
    }

    public function m_add() {
        if (!empty($this->data)) {
            $this->Client->create();
            $this->data['Client']['created_date'] = date('Y-m-d');
            $this->data['Client']['active'] = 1;
            $user = $this->Auth->user();
            $this->data['Client']['created_user_id'] =$user['User']['id'];
            $this->data['Client']['modified_user_id'] =$user['User']['id'];
            $this->data['Client']['modified_date'] = date('Y-m-d');
            if ($this->Client->save($this->data)) {
                $this->Session->setFlash(__('The Client has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Client could not be saved. Please, try again.', true));
            }
        }
        $states = $this->Client->State->find('list');
        $this->set(compact('states'));
        $this->page_title = 'Add New Client';
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/add');
    }
    public function soap_open_invoice_list()
    {
        $jsonComp = new JsonComponent;
        echo $jsonComp->json_open_invoices($this->params['form']['id']);
        exit;
    }
    public function add_check($client_id,$step=1) {
            Configure::write('debug', 2);

        $this->Client->recursive = 0;
        $client = $this->Client->clientforcontractbuild($client_id);
        if($step == 1)
        {
            $clientData = $this->Client->read(null, $client_id);
            $this->set(compact('step','clientData'));
            $this->page_title = $client['Client']['name'].' add check step 1 of 3';
        } elseif ($step == 2)
        {
            if (!empty($this->data)) {
                $this->Client->ClientsCheck->recursive = 0;
                $clientData = $this->Client->read(null, $client_id);

                $jsonComp = new JsonComponent;
                $invoicesRes = $jsonComp->json_open_invoices($client_id);
                $invoices = $invoicesRes['invoices'];
                $invoicesJson = $invoicesRes['json'];
                $this->set(compact('invoices','invoicesJson','clientData','step'));
                $this->page_title = $client['Client']['name'].' add check step 2 of 3';
            }
            else {
                $this->Session->setFlash(__('No Check data passed.', true));
                $this->redirect(array('controller'=>'clients','action'=>'index'));
            }
        } elseif ($step == 3)
        {
            $invList = array_keys ($this->data['Invoice']['Invoice']);
            $this->Client->ClientsCheck->recursive = 0;
            $clientData = $this->Client->read(null, $client_id);

            $this->data['ClientsCheck']['amount']=0;
            //foreach ($this->data['Invoice']['Invoice'] as $invoice):
            foreach ($invList as $invoice):
                $this->data['InvoicesPayment'] = array();
                $this->Client->ClientsContract->Invoice->
                    unbindModel(array('hasMany' => array('ClientsContract','EmployeesPayment',
                        'InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
                $this->Client->ClientsContract->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
                $this->Client->ClientsContract->Invoice->recursive = 1;
                // BROKE
                //$invoiceRes =  $this->Client->ClientsContract->Invoice->read(null,intval ( $invoice));

                /* Database connection information */
                $dataSource = ConnectionManager::getDataSource('default');

                $gaSql['user']       = $dataSource->config['login'];
                $gaSql['password']   = $dataSource->config['password'];
                $gaSql['db']         = $dataSource->config['database'];
                $gaSql['server']     = $dataSource->config['host'];


                $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
                die( 'Could not open connection to server' );

                mysql_select_db( $gaSql['db'], $gaSql['link'] ) or
                die( 'Could not select database '. $gaSql['db'] );
                $invoiceQuery = "SELECT * from invoices where invoices.id=".$invoice."";
                $paymentsQuery = "SELECT * from invoices right join invoices_payments on invoice_id=invoices.id where invoices.id=".$invoice."";

                $rResult = mysql_query( $invoiceQuery, $gaSql['link'] ) or die(mysql_error());
                $invoiceRes = mysql_fetch_array( $rResult );
                $payments = mysql_query( $paymentsQuery, $gaSql['link'] ) or die(mysql_error());
                $balance = $invoiceRes['amount'];

                while ($pay = mysql_fetch_array( $payments ))
                {
                    $balance -= $pay['amount'];
                }

                $invoiceRes['balance'] = $balance;
                $this->data['ClientsCheck']['amount']+=$invoiceRes['balance'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['id']=$invoiceRes['id'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['amount']=$invoiceRes['amount'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['date']=$invoiceRes['date'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['period_start']=$invoiceRes['period_start'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['period_end']=$invoiceRes['period_end'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['notes']=$invoiceRes['notes'];
                $this->data['ClientsCheck']['Invoice'][$invoiceRes['id']]['balance']=$balance;
            endforeach;

            $invoicecount = 0;
            foreach($this->data['ClientsCheck']['Invoice'] as $invoice):
                if( mysql_num_rows($payments))
                {
                    $paymentcount = 0;
                    mysql_data_seek ( $payments , 0 );
                    while ($pay = mysql_fetch_array( $payments ))
                    {
                        $checkRes = $this->Client->ClientsCheck->read(null, $pay['check_id']);

                        $this->data['ClientsCheck']['Invoice'][$pay['invoice_id']]['InvoicesPayment'][$paymentcount]['number']=$checkRes['ClientsCheck']['number'];

                        $this->data['ClientsCheck']['Invoice'][$pay['invoice_id']]['InvoicesPayment'][$paymentcount]['amount']=$checkRes['ClientsCheck']['amount'];

                        $this->data['ClientsCheck']['Invoice'][$pay['invoice_id']]['InvoicesPayment'][$paymentcount]['notes']=$checkRes['ClientsCheck']['notes'];

                        $this->data['ClientsCheck']['Invoice'][$pay['invoice_id']]['InvoicesPayment'][$paymentcount]['date']=$checkRes['ClientsCheck']['date'];
                        $paymentcount++;
                    }
                }
                $invoicecount++;
            endforeach;
            $this->set(compact('clientData','step'));
            $this->page_title = $client['Client']['name'].' add check step 3 of 3';
        } elseif ($step == 4)
        {
            if (!empty($this->data)) {
                $this->Client->ClientsCheck->create();
                $this->data['ClientsCheck']['created_date'] = date('Y-m-d');

                $user = $this->Auth->user();
                $this->data['ClientsCheck']['created_user_id'] =$user['User']['id'];
                $this->data['ClientsCheck']['modified_user_id'] =$user['User']['id'];
                $this->data['ClientsCheck']['modified_date'] = date('Y-m-d');
                if ($this->Client->ClientsCheck->save($this->data)) {
                    $this->Session->setFlash(__('The ClientsCheck has been saved', true));
                    $check_id = $this->Client->ClientsCheck->getLastInsertID ();
                    $count = 0;
                    foreach ($this->data['Invoice']['InvoiceId'] as $invoice):
                        $this->data['InvoicesPayment'] = array();
                        $this->data['InvoicesPayment']['check_id'] = $check_id;
                        $this->data['InvoicesPayment']['invoice_id'] = $invoice['id'];
                        $this->data['InvoicesPayment']['reference'] = $this->data['ClientsCheck']['number'];
                        $this->data['InvoicesPayment']['amount'] = $this->data['Invoice']['InvoiceAmount'][$count]['amount'];
                        $this->data['InvoicesPayment']['notes'] = $this->data['ClientsCheck']['notes'];
                        $this->Client->ClientsCheck->InvoicesPayment->create();
                        $this->Client->ClientsCheck->InvoicesPayment->save($this->data);
                        $this->Client->ClientsContract->Invoice->InvoicesPayment->Invoice->determineClearStatus($invoice['id']);
                        //debug($this->data['InvoicesPayment']);
                        $count++;
                    endforeach;
                    $this->redirect(array('controller'=>'clients','action'=>'view_checks/'.$this->data['ClientsCheck']['client_id']));
                } else {
                    $this->Session->setFlash(__('The ClientsCheck could not be saved. Please, try again.', true));
                    $this->redirect(array('controller'=>'clients','action'=>'view_checks',$this->data['ClientsCheck']['client_id']));
                }
            }
        }elseif ($step == 4)
        {
            $this->page_title = $client['Client']['name'].' add check step 4 of 4';
            $this->set(compact('step','client_id'));
            ;
        }
    }
    public function m_add_check_step4()
    {
        if (!empty($this->data)) {//debug($this->data);exit;
            $this->data['ClientsCheck']['amount'] = 0;
            $count = 0;
            foreach ($this->data['Invoice']['InvoiceId'] as $invoice):
                $this->data['ClientsCheck']['amount'] += $this->data['Invoice']['InvoiceAmount'][$count]['amount'];
                $count++;
            endforeach;
            $this->Client->ClientsCheck->create();
            $user = $this->Auth->user();
            $this->data['ClientsCheck']['created_user_id'] =$user['User']['id'];
            $this->data['ClientsCheck']['modified_user_id'] =$user['User']['id'];
            $this->data['ClientsCheck']['modified_date'] = date('Y-m-d');
            $this->data['ClientsCheck']['created_date'] = date('Y-m-d');
            if ($this->Client->ClientsCheck->save($this->data)) {
                $this->Session->setFlash(__('The ClientsCheck has been saved', true));
                $check_id = $this->Client->ClientsCheck->getLastInsertID ();
                $count = 0;
                foreach ($this->data['Invoice']['InvoiceId'] as $invoice):
                    $this->data['InvoicesPayment'] = array();
                    $this->data['InvoicesPayment']['check_id'] = $check_id;
                    $this->data['InvoicesPayment']['invoice_id'] = $invoice['id'];
                    $this->data['InvoicesPayment']['reference'] = $this->data['ClientsCheck']['number'];
                    $this->data['InvoicesPayment']['amount'] = $this->data['Invoice']['InvoiceAmount'][$count]['amount'];
                    $this->data['InvoicesPayment']['notes'] = $this->data['ClientsCheck']['notes'];
                    $this->Client->ClientsCheck->InvoicesPayment->create();
                    $this->Client->ClientsCheck->InvoicesPayment->save($this->data);
                    $this->Client->ClientsContract->Invoice->InvoicesPayment->Invoice->determineClearStatus($invoice['id']);
                    $count++;
                endforeach;
            } else {
                $this->Session->setFlash(__('The ClientsCheck could not be saved. Please, try again.', true));
            }
        }
        $this->redirect(array('prefix'=>'m','controller'=>'clients','action'=>'view_checks/'.$this->data['ClientsCheck']['client_id']));
    }
    public function m_add_check_step3()
    {
        $client_id = $this->data['Client']['Client']['id'];
        $selected_invoices = $this->data['Invoice']['Invoice'];
        $this->Client->ClientsCheck->recursive = 0;
        $clientData = $this->Client->read(null, $client_id);
        $this->data['ClientsCheck']['amount']=0;
        $select_invoice_numbers = array_keys($selected_invoices);
        foreach ($select_invoice_numbers as $invoice):
            $this->data['InvoicesPayment'] = array();
            $this->Client->ClientsContract->Invoice->
                unbindModel(array('hasMany' => array('ClientsContract','EmployeesPayment',
                    'InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
            $this->Client->ClientsContract->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
            $this->Client->ClientsContract->Invoice->recursive = 1;

            $invoiceRes =  $this->Client->ClientsContract->Invoice->read(null, $invoice);

            $balance = $invoiceRes['Invoice']['amount'];
            foreach ($invoiceRes['InvoicesPayment'] as $pay):
                $balance -= $pay['amount'];
            endforeach;
            $invoiceRes['Invoice']['balance'] = $balance;
            $this->data['ClientsCheck']['amount']+=$invoiceRes['Invoice']['balance'];
            $this->data['ClientsCheck']['Invoice'][]=$invoiceRes;
        endforeach;
        $invoicecount = 0;

        foreach($this->data['ClientsCheck']['Invoice'] as $invoice):
            $paymentcount = 0;
            foreach ($invoice['InvoicesPayment'] as $payment):
                $checkRes = $this->Client->ClientsCheck->read(null, $payment['check_id']);
                $this->data['ClientsCheck']['Invoice'][$invoicecount]['InvoicesPayment'][$paymentcount]['number']=$checkRes['ClientsCheck']['number'];
                $paymentcount++;
            endforeach;
            $invoicecount++;
        endforeach;
        $this->set(compact('clientData','step'));
        $this->page_title = $clientData['Client']['name'].' add check step 4 of 4';
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/add_check_step3');
    }
    public function m_add_check($step=1,$client_id = null)
    {
        $this->Client->recursive = 0;
        if($step == 1)
        {
            $step = 1;
            $clientsMenu = $this->Client->active_jumpto_menu();
            $this->page_title = 'Enter new check (step 1):';
            $this->set(compact('clientsMenu','step'));
        } elseif ($step == 2)
        {
            if (!empty($this->params['pass'])) {
                $this->Client->ClientsCheck->recursive = 0;
                $clientData = $this->Client->read(null, $client_id);
                $this->Client->ClientsContract->Invoice->recursive = 1;
                $this->Client->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem',
                    'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
                $invoices = $this->Client->ClientsContract->Invoice->find('all', array(
                        'conditions'=>array('voided'=>0,'posted'=>1,'cleared'=>0,
                            'ClientsContract.client_id' => $client_id,
                        ),
                        'fields'=>array(
                            'Invoice.id',
                            'Invoice.period_start',
                            'Invoice.period_end',
                            'Invoice.date',
                            'Invoice.terms',
                            'Invoice.amount',
                            'Invoice.contract_id',
                            'Invoice.notes',
                            'ClientsContract.employee_id',
                            'ClientsContract.client_id',
                        ),
                        'order'=>array('Invoice.id ASC'),
                    )
                );//debug($client_id);debug($invoices);exit;
                $invoices = $this->InvoiceFunction->calculateBalances($invoices);
                $this->set(compact('invoices','clientData','step'));
                $this->page_title = $clientData['Client']['name'].' add check step 2 of 3';
            }
            else {
                $this->Session->setFlash(__('No Check data passed.', true));
                $this->redirect(array('controller'=>'clients','action'=>'index'));
            }
        }
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/add_check');
    }
    public function add_contract($client_id = null,$step=1, $employee_id=null) {
        $client = $this->Client->clientforcontractbuild($client_id);
        // In the forms
        if (!empty($this->data)) {
            $contract = $this->save_contract($this->data);
            if ($contract['ClientsContract']['success'] == 1)
            {
                $this->redirect(array('action'=>'view_active_contracts',$contract['ClientsContract']['client_id']));
            } else {
                return;
            }
        }
        # Comming in from the navs
        else
        {
            $this->add_contract_setup_view($client_id,$step,$employee_id);
        }
    }
    public function m_add_contract($client_id = null,$step=1, $employee_id=null) {
        $client = $this->Client->clientforcontractbuild($client_id);
        // In the forms
        if (!empty($this->data)) {
            $contract = $this->save_contract($this->data);
            if ($contract['ClientsContract']['success'] == 1)
            {
                $this->redirect(array('action'=>'contracts/'.$contract['ClientsContract']['client_id']));
            } else {
                return;
            }
        }
        # Comming in from the navs
        else
        {
            $this->add_contract_setup_view($client_id,$step,$employee_id);
        }
        $this->page_title = 'Add New Contract';
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/add_contract');
    }
    public function auto_add_items() {
        if($this->data['ContractsItem']['method'] == 1)
        {
            if ($this->data['ContractsItem']['cost'] != null && $this->data['ContractsItem']['contract_id']!= null)
            {
                if($this->Client->ClientsContract->ContractsItem->auto_add_items($this->data['ContractsItem']['contract_id'],
                        $this->data['ContractsItem']['cost'],
                        $user = $this->Auth->user()
                    ) == True)
                {
                    $this->redirect(array('action'=>'view_contract_items',$this->data['ContractsItem']['contract_id']));
                }
                else
                {
                    $this->Session->setFlash(__('Bad Contract ID bad cost', true));
                    $this->redirect(array('action'=>'index'));
                }
            }
            else
            {
                $this->Session->setFlash(__('Bad Contract ID bad cost', true));
                $this->redirect(array('action'=>'index'));
            }
        } elseif ($this->data['ContractsItem']['method'] == 2)
        {
            if ($this->data['ContractsItem']['cost'] != null && $this->data['ContractsItem']['contract_id']!= null)
            {
                if($this->Client->ClientsContract->ContractsItem->auto_add_items_method2($this->data['ContractsItem']['contract_id'],
                        $this->data['ContractsItem']['cost'],
                        $user = $this->Auth->user(),
                        $this->data['ContractsItem']['amount']
                    ) == True)
                {
                    $this->redirect(array('action'=>'view_contract_items',$this->data['ContractsItem']['contract_id']));
                }
                else
                {
                    $this->Session->setFlash(__('Bad Contract ID bad cost', true));
                    $this->redirect(array('action'=>'index'));
                }
            }
            else
            {
                $this->Session->setFlash(__('Bad Contract ID bad cost', true));
                $this->redirect(array('action'=>'index'));
            }

        }
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

                $this->Client->ClientsContract->ContractsItem->create();
                if ($this->Client->ClientsContract->ContractsItem->save($this->data)) {
                    $this->Session->setFlash(__('The Item has been saved', true));
                    $this->redirectFromContractsItem($this->data);
                } else {
                    $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
                }
            }else
            {
                $clientsContract = $this->Client->ClientsContract->read(null, $contract_id);
                $client = $this->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
                $this->page_title = 'Add billable item for '.$client['Client']['name'].' contract - '.$clientsContract['ClientsContract']['title'];
                $next = $this->params['named']['next'];
                $this->set(compact('next','clientsContract'));
                $this->data['ContractsItem']['contract_id'] = $contract_id;
            }
        }
    }

    public function m_add_contract_item($contract_id = null,$next = null) {
        if ($contract_id == null && !isset($this->data['ContractsItem']['contract_id']))
        {
            $this->Session->setFlash(__('Bad Contract ID', true));
            $this->redirect(array('action'=>'index'));
        } else
        {
            if (!empty($this->data))
            {
                $this->data['ContractsItem']['created_date'] = date('Y-m-d');
                $this->data['ContractsItem']['created_user_id'] = $user['User']['id'];
                $this->data['ContractsItem']['active'] = 1;
                $user = $this->Auth->user();
                $this->Client->ClientsContract->ContractsItem->create();
                if ($this->Client->ClientsContract->ContractsItem->save($this->data)) {
                    $this->Session->setFlash(__('The Item has been saved', true));

                    $this->redirect(array('prefix'=>'m','controller'=>'clients','action'=>'view_contract/'.$this->data['ContractsItem']['contract_id'] ));
                } else {
                    $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
                }
            }else
            {
                $clientsContract = $this->Client->ClientsContract->read(null, $contract_id);
                $client = $this->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
                $this->page_title = 'Add billable item for '.$client['Client']['name'].' contract - '.$clientsContract['ClientsContract']['title'];
                $next = $this->params['named']['next'];
                $this->set(compact('next','clientsContract'));
                $this->data['ContractsItem']['contract_id'] = $contract_id;
            }
        }
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/add_contract_item');
    }
    public function add_contract_comm_item($item_id=null,$next=null) {
        if (!empty($this->data)) { //debug($this->data);exit;
            $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->create();
            $this->data['ContractsItemsCommissionsItem']['created_date'] = date('Y-m-d');
            if ($this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->save($this->data)) {
                $this->Session->setFlash(__('The Commissions has been saved', true));
                $item = $this->Client->ClientsContract->ContractsItem->read(null, $this->data['ContractsItemsCommissionsItem']['contracts_items_id']);
                $this->data['ContractsItem'] = $item ['ContractsItem'];
                $this->data['ContractsItem']['next'] = $this->data['ContractsItemsCommissionsItem']['next'] ;
                $this->redirectFromContractsItem($this->data);
            } else {
                $this->Session->setFlash(__('The Commissions could not be saved. Please, try again.', true));
            }
        }
        $item = $this->Client->ClientsContract->ContractsItem->read(null, $item_id);
        $contract = $this->Client->ClientsContract->read(null, $item['ContractsItem']['contract_id']);
        $this->data['ContractsItemsCommissionsItem']['contracts_items_id'] = $item_id;
        $this->data['ClientsContract'] = $contract['ClientsContract'];
        $this->Client->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $this->Client->ClientsContract->Employee->unbindModel(array('belongsTo' => array('State'),),false);
        $employeesAll = $this->Client->ClientsContract->Employee->find('all',array('conditions'=>array('Employee.active'=>1,'Employee.salesforce'=>1)));

        $employees = array();
        foreach ($employeesAll as $employee):

            $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        endforeach;
        $this->set(compact('employees','next','contract','employee'));
    }
    public function add_manager($client_id=null) {
        if (!empty($this->data)) {
            $this->Client->ClientsManager->create();
            $this->data['ClientsManager']['created_date'] = date('Y-m-d');
            if ($this->Client->ClientsManager->save($this->data)) {
                $this->Session->setFlash(__('The ClientsManager has been saved', true));
                $this->redirect(array('controller'=>'clients','action'=>'view_managers',$this->data['ClientsManager']['client_id']));
            } else {
                $this->Session->setFlash(__('The ClientsManager could not be saved. Please, try again.', true));
            }
        }
        $this->data['ClientsManager']['client_id'] = $client_id;
    }

    public function m_add_manager($client_id=null) {
        if (!empty($this->data)) {
            $this->Client->ClientsManager->create();
            $this->data['ClientsManager']['created_date'] = date('Y-m-d');
            if ($this->Client->ClientsManager->save($this->data)) {
                $this->Session->setFlash(__('The ClientsManager has been saved', true));
                $this->redirect(array('controller'=>'clients','action'=>'view_managers',$this->data['ClientsManager']['client_id']));
            } else {
                $this->Session->setFlash(__('The ClientsManager could not be saved. Please, try again.', true));
            }
        }
        $this->data['ClientsManager']['client_id'] = $client_id;

        $this->layout = "default_jqmobile";
        $this->render('/clients/m/add_manager');
    }
    public function add_memo($client_id=null) {
        if (!empty($this->data)) {
            $this->Client->ClientsMemo->create();
            $this->data['ClientsMemo']['created_date'] = date('Y-m-d');
            if ($this->Client->ClientsMemo->save($this->data)) {
                $this->Session->setFlash(__('The Memo has been saved', true));
                $this->redirect(array('action'=>'view_memos',$this->data['ClientsMemo']['client_id']));
            } else {
                $this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
            }
        }
        $this->data['ClientsMemo']['client_id'] = $client_id;
        $clients = $this->Client->ClientsMemo->find('list',array('conditions'=>array($client_id)));
        $this->set(compact('clients'));
    }
    public function add_search($client_id=null) {
        if (!empty($this->data)) {
            $this->Client->ClientsSearch->create();
            $this->data['ClientsSearch']['active'] = 1;
            $this->data['ClientsSearch']['created_date'] = date('Y-m-d');
            if ($this->Client->ClientsSearch->save($this->data)) {
                $this->Session->setFlash(__('The Search has been saved', true));
                $this->redirect(array('action'=>'view_active_searches',$this->data['ClientsSearch']['client_id']));
            } else {
                $this->Session->setFlash(__('The Search could not be saved. Please, try again.', true));
            }
        }
        $this->data['ClientsSearch']['client_id'] = $client_id;
        $resumes = $this->Client->ClientsSearch->Resume->find('list',array(
            'fields'=>array('id','name'),
            'conditions'=>array('active'=>1),
            'order'=>array('name'=>'ASC'),
        ));
        $clients = $this->Client->ClientsSearch->Client->find('list');
        $this->set(compact('resumes', 'clients'));
    }

    public function edit_check($id = null) { // Just display advice to delete check an redo.  If the list of invoices on check is the same, then edit values in the check view.
        if (empty($this->data)) {
            $next = $this->params['named']['next'];
            $this->data = $this->Client->ClientsCheck->read(null,$id);
            $this->data['ClientsCheck']['next'] = $next;
            // clientData instead of client because of conflict with clientHelper
            $clientData = $this->Client->clientforcontractbuild($this->data['ClientsCheck']['client_id']);
            $this->set(compact('clientData','next'));
            $this->page_title = $clientData['Client']['name'].' check #'.$this->data['ClientsCheck']['number'];
            $clientsCheck = $this->Client->ClientsCheck->checkforpaymentreview($id);
            $client = $this->Client->clientforcontractbuild($clientsCheck['ClientsCheck']['client_id']);
            $this->set(compact('clientsCheck','client'));
        } else
        {
            $check = $this->Client->ClientsCheck->read(null,$id);
            $user = $this->Auth->user();
            $this->data['ClientsCheck']['modified_user_id'] =$user['User']['id'];
            $this->data['ClientsCheck']['modified_date'] = date('Y-m-d');
            if ($this->Client->ClientsCheck->save($this->data)) {
                $this->Session->setFlash(__('The Check has been saved', true));
                $this->redirect(array('action'=>'view_checks/'.$this->data['ClientsCheck']['client_id']));
            } else {
                $this->Session->setFlash(__('The Check could not be saved. Please, try again.', true));
            }
        }
    }
    public function edit_contract($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsContract', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->data['ClientsContract']['ClientsManager'] = $this->data['Clients']['ClientsManager'];
            $this->data['ClientsContract']['User'] = $this->data['Clients']['User'];
            if ($this->Client->ClientsContract->save($this->data)) {
                $this->Session->setFlash(__('The Contract has been saved', true));
                $this->redirect(array('action'=>'view_contract',$this->data['ClientsContract']['id']));
            } else {
                $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
            }
        }
        if ($id && empty($this->data)) {
            $this->data = $this->Client->ClientsContract->read(null, $id);
            $employees = $this->Client->ClientsContract->Employee->find('list');
            $clients = $this->Client->ClientsContract->Client->find('list');
            $periods = $this->Client->ClientsContract->Period->find('list');
            $managers = $this->Client->ClientsContract->ClientsManager->find('all',array(
                'conditions'=>array('client_id'=>$this->data['ClientsContract']['client_id']),
                'order'=>array("firstname ASC","lastname ASC"),
            ));
            $users = $this->Client->ClientsContract->User->find('all');
            $managersoptions = array();
            $usersoptions = array();
            foreach ($managers as $manager):
                $managersoptions[$manager['ClientsManager']['id']] = $manager['ClientsManager']['title'].':'.$manager['ClientsManager']['firstname'].' '.$manager['ClientsManager']['lastname'].' '.$manager['ClientsManager']['email'];
            endforeach;
            foreach ($users as $user):
                $usersoptions[$user['User']['id']] = $user['User']['firstname'].' '.$user['User']['lastname'].' '.$user['User']['email'];
            endforeach;
            $this->set(compact('employees','clients','periods','managersoptions','usersoptions'));
        } else {

            if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid ClientsContract', true));
                $this->redirect(array('action'=>'index'));
            }
        }
    }
    public function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Client', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $user = $this->Auth->user();
            $this->data['Client']['modified_user_id'] =$user['User']['id'];
            $this->data['Client']['modified_date'] = date('Y-m-d');
            $this->log('Modified client terms '.$this->data['Client']['terms'], 'debug');

            if ($this->Client->save($this->data)) {
                $this->Session->setFlash(__('The Client has been saved', true));
                $this->redirect(array('action'=>'view',$this->data['Client']['id']));
            } else {
                $this->Session->setFlash(__('The Client could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->read(null, $id);
            $this->log('Read client name '.$this->data['Client']['name'], 'debug');
            $this->log('Read client terms '.$this->data['Client']['terms'], 'debug');
        }
        $states = $this->Client->State->find('list');
        $this->set(compact('states'));
        $this->page_title = $this->data['Client']['name'].' edit';
    }
    public function edit_contract_item($id = null,$next=null) {

        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ContractsItem', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) { //debug($this->data);//exit;
            $next = $this->data['ContractsItem']['next']; // gets lost down stream
            $item = $this->Client->ClientsContract->ContractsItem->read(null, $this->data['ContractsItem']['id']);//debug($item);//exit;

            $user = $this->Auth->user();
            $this->data['ContractsItem']['modified_date'] = date('Y-m-d');
            $this->data['ContractsItem']['modified_user_id'] = $user['User']['id'];
            if ($this->Client->ClientsContract->ContractsItem->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->data['ContractsItem']= $item['ContractsItem'];
                $this->data['ContractsItem']['next']= $next;
                $this->redirectFromContractsItem($this->data);
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsContract->ContractsItem->read(null, $id);
            $this->data['ClientsContract'] = $this->Client->ClientsContract->read(null, $this->data['ContractsItem']['contract_id']);

            $clientsContract = $this->Client->ClientsContract->read(null, $this->data['ContractsItem']['contract_id']);
            $client = $this->Client->clientforcontractbuild($clientsContract['ClientsContract']['client_id']);
            $this->page_title = 'Edit billable item for '.$client['Client']['name'].' contract - '.$clientsContract['ClientsContract']['title'];

            $next = 'view_contract_items';
            $this->set(compact('next'));
        }
    }
    public function edit_contract_comm_item($id = null,$contract_id,$next = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ContractsItemsCommissionsItem', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->save($this->data)) {
                $this->Session->setFlash(__('The Commissions has been saved', true));
                $citem = $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $this->data['ContractsItemsCommissionsItem']['id']);
                $item = $this->Client->ClientsContract->ContractsItem->read(null, $citem['ContractsItemsCommissionsItem']['contracts_items_id']);
                $this->data['ContractsItem'] = $item ['ContractsItem'];
                $this->data['ContractsItem']['next'] = $this->data['ContractsItemsCommissionsItem']['next'] ;
                $this->redirectFromContractsItem($this->data);
            } else {
                $this->Session->setFlash(__('The Commissions could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $id);
        }
        $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->Employee->unbindModel(array('belongsTo' => array('State'),),false);

        $employeesAll = $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->Employee->find('all',array('conditions'=>array('active'=>1,'salesforce'=>1)));
        $employees = array();
        foreach ($employeesAll as $employee):
            $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
        endforeach;
        $item = $this->Client->ClientsContract->ContractsItem->read(null, $this->data['ContractsItemsCommissionsItem']['contracts_items_id']);
        $this->Client->ClientsContract->unbindModel(array('belongsTo' => array('Employee','Client','Period'),),false);
        $this->Client->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->Client->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('User','ClientsManager'),),false);
        $contract = $this->Client->ClientsContract->read(null, $item['ContractsItem']['contract_id']);
        //$next = $this->params['named']['next'];
        $this->set(compact('employees','contract','next'));
    }
    public function edit_manager($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsManager', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Client->ClientsManager->save($this->data)) {
                $this->Session->setFlash(__('The ClientsManager has been saved', true));
                $this->redirect(array('controller'=>'clients','action'=>'view_managers',$this->data['ClientsManager']['client_id']));
            } else {
                $this->Session->setFlash(__('The ClientsManager could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsManager->read(null, $id);
        }
    }
    public function edit_memo($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsMemo', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Client->ClientsMemo->save($this->data)) {
                $this->Session->setFlash(__('The Memo has been saved', true));
                $this->redirect(array('action'=>'view_memos',$this->data['ClientsMemo']['client_id']));
            } else {
                $this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsMemo->read(null, $id);
        }
    }
    public function edit_payment($id = null) {
        $crumbs = $this->Session->read('crumb_links');
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid InvoicesPayment', true));
            $this->redirect($crumbs[0]);
        }
        if (!empty($this->data)) {
            $invoice_id = $this->data['InvoicesPayment']['invoice_id'];
            if ($this->Client->ClientsContract->Invoice->InvoicesPayment->save($this->data)) {
                $this->Session->setFlash(__('The Payment has been saved', true));
                $this->Client->ClientsContract->Invoice->InvoicesPayment->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
                $this->Client->ClientsContract->Invoice->InvoicesPayment->Invoice->determineClearStatus($invoice_id);
                $this->redirect($crumbs[0]);
            } else {
                $this->Session->setFlash(__('The Payment could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsContract->Invoice->InvoicesPayment->read(null, $id);
        }
    }
    public function edit_search($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Search', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) { //debug($this->data);exit;
            if ($this->Client->ClientsSearch->save($this->data)) {
                $this->Session->setFlash(__('The Search has been saved', true));
                $this->redirect(array('action'=>'view_active_searches',$this->data['ClientsSearch']['client_id']));
            } else {
                $this->Session->setFlash(__('The Search could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsSearch->read(null, $id);
            //debug($this->data);
            $currentRes = array();
            foreach ($this->data['Resume'] as $res):
                $currentRes[]=$res['id'];
            endforeach;
            $resumesAct = $this->Client->ClientsSearch->Resume->find('list',array(
                'fields'=>array('id'),
                'conditions'=>array('active'=>1),
                'order'=>array('name'=>'ASC'),
            ));
            foreach ($resumesAct as $res):
                if(!in_array($res, $currentRes))
                {
                    $currentRes[]=$res;
                }
            endforeach;
            $resumes = array();
            $this->Client->ClientsSearch->Resume->unbindModel(array('hasAndBelongsToMany' => array('ClientsSearch'),),false);
            $this->Client->ClientsSearch->Resume->unbindModel(array('belongsTo' => array('State'),),false);
            foreach ($currentRes as $res):
                $resume = $this->Client->ClientsSearch->Resume->read(array('id','name'),$res);
                $resumes[$res] = $resume['Resume']['name'];
            endforeach;
            $clients = $this->Client->ClientsSearch->Client->find('list');
            $this->set(compact('resumes','clients'));
        }
    }
    public function edit_invoice($invoice_id = null)
    {
        /*
         * possible values for next,  entry points, to return to
         *
        view_invoices_pending -
        view_invoice -
        view_invoices_pastdue -

         */

        if(empty($this->data))
        {
            if($this->params['pass'][0])
            {
                $employees = $this->Client->ClientsContract->Employee->salesStaff();
                $this->set(compact('employees'));
                $next = $this->params['named']['next'];
                $this->set(compact('next'));
                $this->data = $this->Client->ClientsContract->Invoice->getInvoiceReview($invoice_id);
                $this->page_title = 'Edit Invoice: '.$this->data['Invoice']['id'].'-'.$this->data['Client']['Client']['name'].' - '.$this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'];
            }
        } else {

            $user = $this->Auth->user();
            $this->data['Invoice']['modified_user_id'] =$user['User']['id'];
            $this->data['Invoice']['modified_date'] = date('Y-m-d');
            $invoiceToSave = $this->InvoiceFunction->AdjustDatesBeforeSave($this->data);
            $res = $this->Client->ClientsContract->Invoice->save_dynamic($invoiceToSave);

            if($res[0] > 0)
            {
                /*
                 * setup flash message from messages from model
                 */
                $outmsg = '';
                foreach($res[1] as $msg)
                {
                    $outmsg .= $msg. ' ';
                }
                $this->Session->setFlash(__($outmsg, true));
            }
            $invoice = $this->Client->ClientsContract->Invoice->read(null,$this->data['Invoice']['id']);
            $contract = $this->Client->ClientsContract->read(null,$invoice['Invoice']['contract_id']);

            switch ($this->data['Invoice']['next']) {
                case "view_invoices_pending":
                    $this->setup_view_invoices_pending($contract['ClientsContract']['client_id']);
                    $this -> render('view_invoices_pending');
                    break;
                case "view_invoice":
                    $this->data = $this->Client->ClientsContract->Invoice->getInvoiceReview($invoice_id);
                    $this->page_title = 'Edit Invoice: '.$this->data['Invoice']['id'].'-'.
                        $this->data['Client']['Client']['name'].' - '.
                        $this->data['Employee']['Employee']['firstname'].
                        ' '.$this->data['Employee']['Employee']['lastname'];
                    $this -> render('view_invoice');
                    break;
                case "view_invoices_pastdue":
                    $this->setup_view_invoices_pastdue($contract['ClientsContract']['client_id']);
                    $this -> render('view_invoices_pastdue');
                    break;
            }
        }
    }
    public function edit_openinginvoice($invoice_id = null)
    {
        /*
         * fixme - this has no route to it , no workflow, no view
         * used (duplicated in opening invoice controller
         */
        if(empty($this->data))
        {
            if($this->params['pass'][0])
            {
                $employees = $this->Client->ClientsContract->Employee->salesStaff();
                $this->set(compact('employees'));
                $next = $this->params['named']['next'];
                $this->set(compact('next'));
                $this->data = $this->Client->ClientsContract->Invoice->getInvoiceReview($invoice_id);
                $this->page_title = 'Edit Invoice: '.$this->data['Invoice']['id'].'-'.
                    $this->data['Client']['Client']['name'].' - '.$this->data['Employee']['Employee']['firstname'].
                    ' '.$this->data['Employee']['Employee']['lastname'];
            }
        } else {
            $invoiceToSave = $this->InvoiceFunction->AdjustDatesBeforeSave($this->data);
            $this->Client->ClientsContract->Invoice->save_dynamic($invoiceToSave,$this->Session);
            $invoice = $this->Client->ClientsContract->Invoice->read(null,$this->data['Invoice']['id']);
            $contract = $this->Client->ClientsContract->read(null,$invoice['Invoice']['contract_id']);
            $this->redirect(array('action'=>$this->data['Invoice']['next'],$contract['ClientsContract']['client_id'],
                'next'=>$this->data['Invoice']['next']));
            $this->redirect(array('action'=>$this->data['Invoice']['next'],$this->data['Invoice']['id'],
                'next'=>$this->data['Invoice']['next']));
        }
    }

    public function edit_mock_invoice($invoice_id = null)
    {
        if(empty($this->data))
        {
            if($invoice_id)
            {

                $employees = $this->Client->ClientsContract->Employee->find('list');

                $clientsContract = $this->Client->ClientsContract->clientcontract_mock_invoice_manage($this->data['Invoice']['contract_id']);

                $employeesRaw = $this->Client->ClientsContract->Employee->find('all',null);
                $employees = Array();
                foreach($employeesRaw as $employee)
                {
                    $employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                }
                $this->set('employees', $employees);
                $this->set('clientsContract', $clientsContract);
            }
        } else {
            $this->Client->ClientsContract->Invoice->save_dynamic($this->data,$this->Session);
            $invoice = $this->Client->ClientsContract->Invoice->read(null,$this->data['Invoice']['id']);
            $contract = $this->Client->ClientsContract->read(null,$invoice['Invoice']['contract_id']);
            $this->redirect(array('action'=>'view_mock_invoice',$this->data['Invoice']['contract_id']));
        }
    }
    public function rebuild_invoice($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->Invoice->rebuild_invoice($id);
        $this->redirect(array('action'=>'edit_invoice/'.$id.'/next:'.$this->params['named']['next']));
    }
    public function rebuild_mock_invoice($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->Invoice->rebuild_invoice($id);
        $this->redirect(array('action'=>'edit_mock_invoice/'.$id));
    }
    public function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Client', true));
            $this->redirect(array('action'=>'search_s'));
        }
        if ($this->Client->delete($id)) {
            $this->Session->setFlash(__('Client deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }
    public function delete_check($id = null,$next = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Check', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->Invoice->recursion = 0;
        $this->Client->ClientsContract->Invoice->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $this->Client->ClientsContract->Invoice->unbindModel(array('hasMany' => array(
            'InvoicesItem',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
        ),),false);
        $this->data = $this->Client->ClientsCheck->read(null, $id);
        if ($this->Client->ClientsCheck->delete($id)) {
            foreach ($this->data['InvoicesPayment'] as $invoice):
                $this->Client->ClientsContract->Invoice->InvoicesPayment->Invoice->determineClearStatus($invoice['invoice_id']);
            endforeach;
            $this->Session->setFlash(__('Check deleted', true));
            $this->redirect(array('action'=>'view_checks/'.$this->data['ClientsCheck']['client_id']));
        } else {
            $this->redirect(array('action'=>'view_checks/'.$this->data['ClientsCheck']['client_id']));

	}
    }
    public function delete_contract($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Contract', true));
            $this->redirect(array('action'=>'index'));
        }
        $contract = $this->Client->ClientsContract->read(null, $id);
        $this->Client->ClientsContract->delete($id);
        $this->Session->setFlash(__('Contract deleted', true));
        $this->redirect(array('action'=>'view_active_contracts',$contract['ClientsContract']['client_id']));
    }
    public function delete_contract_item($id = null ) {
        $id = $this->params['pass'][0];
        $this->data = array();
        $this->data['next']=$this->params['pass'][2];
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Item', true));
            $this->redirect(array('action'=>'view'));
        }
        $item = $this->Client->ClientsContract->ContractsItem->read(null, $id);//debug($item);exit;
        if ($this->Client->ClientsContract->ContractsItem->delete($id)) { //debug($this->data);exit;
            $this->Session->setFlash(__('Item deleted', true));
            $this->data['ContractsItem']= $item['ContractsItem'];
            $this->data['ContractsItem']['next']= $this->data['next'];
            $this->redirectFromContractsItem($this->data);
        } else {
            $this->Session->setFlash(__('Invalid id for Item', true));
            $this->redirect(array('action'=>'view'));
        }
    }
    public function delete_contract_comm_item($id = null,$contract_id,$next = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Commissions', true));
            $this->redirect(array('action'=>'index'));
        }
        $citem = $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->read(null, $id);
        $item = $this->Client->ClientsContract->ContractsItem->read(null, $citem['ContractsItemsCommissionsItem']['contracts_items_id']);
        if ($this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->delete($id)) {
            $this->Session->setFlash(__('Commissions Item deleted', true));
            $this->data['ContractsItem']= $item['ContractsItem'];
            $this->data['ContractsItem']['next']= $next;
            $this->redirectFromContractsItem($this->data);
        }
    }
    public function delete_manager($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Manager', true));
            $this->redirect(array('action'=>'index'));
        }
        $manager = $this->Client->ClientsManager->read(null, $id);
        if ($this->Client->ClientsManager->delete($id)) {
            $this->Session->setFlash(__('Manager deleted', true));
            $this->redirect(array('action'=>'view_managers',$manager['ClientsManager']['client_id']));
        }
    }
    public function delete_memo($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Memo', true));
            $this->redirect(array('action'=>'index'));
        }
        $memo = $this->Client->ClientsMemo->read(null, $id);
        if ($this->Client->ClientsMemo->delete($id)) {
            $this->Session->setFlash(__('Memo deleted', true));
            $this->redirect(array('action'=>'view_memos',$memo['ClientsMemo']['client_id']));
        }
    }
    public function delete_search($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Search', true));
            $this->redirect(array('action'=>'index'));
        }
        $search = $this->Client->ClientsSearch->read(null, $id);
        if ($this->Client->ClientsSearch->delete($id)) {
            $this->Session->setFlash(__('Search deleted', true));
            $this->redirect(array('action'=>'view_active_searches', $search['ClientsSearch']['client_id']));
        }
    }
    public function search() {
        if (!empty($this->data)) {
            $paginate = array( 'limit' => 10,);
            $filter = $this->Search->process($this);
            $this->set('clients', $this->paginate(null, $filter));
        } else
        {
            $this->Client->recursive = 0;
            $this->set('clients', $this->paginate());
        }
        $states = $this->Client->State->find('list');
        $this->set(compact('states'));
    }
    public function manage_contract_items($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 0;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Client->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $this->Client->ClientsContract->ContractsItem->recursive=2;
        $this->Client->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Client->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
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

    public function m_manage_contract_items($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Contract.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Client->ClientsContract->recursive = 0;
        $clientsContract = $this->Client->ClientsContract->read(null, $id);
        $this->set('clientsContract', $clientsContract);
        $invoices = $this->Client->ClientsContract->Invoice->find('all', array('conditions'=>array(
            'contract_id'=>$clientsContract['ClientsContract']['id'],
            'voided'=>0
        ),
            'order'=>array('date DESC')));
        $this->Client->ClientsContract->ContractsItem->recursive=2;
        $this->Client->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $items = $this->Client->ClientsContract->ContractsItem->find('all', array('conditions'=>array(
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
    public function manage_contract_emails($id = null) {


        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsContract', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->data['ClientsManager']['ClientsManager'] = $this->data['ClientsContract']['ClientsManager'];
            $this->data['User']['User'] = $this->data['ClientsContract']['User'];
            if ($this->Client->ClientsContract->save($this->data)) {
                $this->Session->setFlash(__('The Contract has been saved', true));
                $this->redirect(array('action'=>'view_contract_emails',$this->data['ClientsContract']['id']));
            } else {
                $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsContract->read(null, $id);
            $employees = $this->Client->ClientsContract->Employee->find('list');
            $clients = $this->Client->ClientsContract->Client->find('list');
            $periods = $this->Client->ClientsContract->Period->find('list');
            $managers = $this->Client->ClientsContract->ClientsManager->find('all',array(
                'conditions'=>array('client_id'=>$this->data['ClientsContract']['client_id']),
                'order'=>array("firstname ASC","lastname ASC"),
            ));
            $users = $this->Client->ClientsContract->User->find('all');
            $managersoptions = array();
            $usersoptions = array();
            foreach ($managers as $manager):
                $managersoptions[$manager['ClientsManager']['id']] = $manager['ClientsManager']['title'].':'.$manager['ClientsManager']['firstname'].' '.$manager['ClientsManager']['lastname'].' '.$manager['ClientsManager']['email'];
            endforeach;
            foreach ($users as $user):
                if ($user['User']['group_id']== 1)
                    $usersoptions[$user['User']['id']] = $user['User']['firstname'].' '.$user['User']['lastname'].' '.$user['User']['email'];
            endforeach;
            $this->set(compact('employees','clients','periods','managersoptions','usersoptions'));
        }
    }

    public function m_manage_contract_emails($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid ClientsContract', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->data['ClientsManager']['ClientsManager'] = $this->data['ClientsContract']['ClientsManager'];
            $this->data['User']['User'] = $this->data['ClientsContract']['User'];
            if ($this->Client->ClientsContract->save($this->data)) {
                $this->Session->setFlash(__('The Contract has been saved', true));
                $this->redirect(array('action'=>'view_contract_emails',$this->data['ClientsContract']['id']));
            } else {
                $this->Session->setFlash(__('The Contract could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Client->ClientsContract->read(null, $id);
            $employees = $this->Client->ClientsContract->Employee->find('list');
            $clients = $this->Client->ClientsContract->Client->find('list');
            $periods = $this->Client->ClientsContract->Period->find('list');
            $managers = $this->Client->ClientsContract->ClientsManager->find('all',array(
                'conditions'=>array('client_id'=>$this->data['ClientsContract']['client_id']),
                'order'=>array("firstname ASC","lastname ASC"),
            ));
            $users = $this->Client->ClientsContract->User->find('all');
            $managersoptions = array();
            $usersoptions = array();
            foreach ($managers as $manager):
                $managersoptions[$manager['ClientsManager']['id']] = $manager['ClientsManager']['title'].':'.$manager['ClientsManager']['firstname'].' '.$manager['ClientsManager']['lastname'].' '.$manager['ClientsManager']['email'];
            endforeach;
            foreach ($users as $user):
                if ($user['User']['group_id']== 1)
                    $usersoptions[$user['User']['id']] = $user['User']['firstname'].' '.$user['User']['lastname'].' '.$user['User']['email'];
            endforeach;
            $this->set(compact('employees','clients','periods','managersoptions','usersoptions'));
        }
        $this->layout = "default_jqmobile";
        $this->render('/clients/m/manage_contract_emails');
    }
    function redirectFromContractsItem($data)
    {
        //debug($data);exit;
        $clientsContract = $this->Client->ClientsContract->clientcontract_mock_invoice_manage($data['ContractsItem']['contract_id']);
        $next = $data['ContractsItem']['next'];
        //debug(array('action'=>$data['ContractsItem']['next'], $data['ContractsItem']['contract_id']));exit;
        if( $next == 'view_mock_invoice' || $next == 'view_contract_items' )
        {
            $this->redirect(array('action'=>$data['ContractsItem']['next'], $data['ContractsItem']['contract_id']));
        }
        if($next='delete_contract_item')
        {
            $this->redirect(array('action'=>$data['ContractsItem']['next'], $data['ContractsItem']['contract_id']));
        } else if ($next='delete_contract_item')
        {
            $this->redirect(array('action'=>$data['ContractsItem']['next'], $data['ContractsItem']['contract_id']));
        }
    }
    /*
     *  Non-AJAX action for changing commissions rates
     *  but does skip page refresh
     */
    public function change_rates()
    {

        $params = $this->params['data'];
        foreach( $params as $item)
        {
            $this->data = array();
            $this->data['ContractsItemsCommissionsItem'] = $item;
            $this->Client->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->save($this->data);
        }
        header('Content-type: application/json');
        echo '{';
        echo '}'; exit;
    }
    public function push_invoice_to_timecards($id)
    {
        $invoice['Invoice']['timecard'] = 1;
        $this->Client->ClientsContract->Invoice->save($invoice);
        $this->redirect(array('controller'=>'reminders','action'=>'timecards'));
    }

    public function m_push_invoice_to_timecards($id)
    {
        $this->layout = "default_jqmobile";

        $invoice['Invoice']['timecard'] = 1;
        $this->Client->ClientsContract->Invoice->save($invoice);
        $this->redirect(array('prefix'=>'m','controller'=>'reminders','action'=>'timecards'));
    }

    public function soap_Contract_activeinactive($id, $updown)
    {
        $this->layout = Null;
        $this->data['ClientsContract']['id']=$id;
        $this->data['ClientsContract']['active']=$updown;
        if ($this->Client->ClientsContract->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }

    public function soap_Contract_addendum($id,$updown)
    {
        $this->layout = Null;
        $this->data['ClientsContract']['id']=$id;
        $this->data['ClientsContract']['addendum_executed']=$updown;
        if ($this->Client->ClientsContract->save($this->data)) {
            $this->render('/elements/empty_soap_return');;
        } else {
            ;
        }
    }
    public function beforeFilter(){
        parent::beforeFilter();
        $this->page_title = 'Clients Page';
        if(isset($this->Security) && $this->RequestHandler->isAjax() && in_array($this->action ,array(
                'change_rates',
                'm_check_add',
                'm_add_check_step3',
                'soap_Contract_activeinactive',
                'soap_Contract_addendum',
            ))){
            Configure::write('debug', 0);
            $this->Security->enabled = false;
        }

        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
                'm_check_add',
                'm_add_check_step3',
                'm_add_check_step4',
                'add_check',
                'add_contract',
                'edit_check',
                'add_memo',
                'edit_check',
                'edit_contract',
                'edit_memo',
                'edit_manager',
                'edit_invoice',
                'add_manager',
                'soap_open_invoice_list',
                'manage_contract_emails',
                'add_contract_comm_item',
                'edit_contract_item',
            ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
        }
    }

    public function beforeRender(){
        parent::BeforeRender();
        $this->set('page_title',$this->page_title);
    }
}
?>
