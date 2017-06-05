<?php
// require_once("XML/Unserializer.php");
// require_once("XML/Serializer.php");

require_once dirname(__FILE__) . '/../XML/Serializer.php';

require_once dirname(__FILE__) . '/../XML//Unserializer.php';
require_once("app/controllers/components/statements.php");
require_once("app/controllers/components/date_function.php");

App::import('Component', 'Json');
App::import('Component', 'Datasources');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');

class Client extends AppModel {
    var $name = 'Client';
    var $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'State' => array('className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => array('id','name','post_ab'),
            'order' => ''
        )
    );
    var $hasMany = array(
        'ClientsContract' => array('className' => 'ClientsContract',
            'foreignKey' => 'client_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'ClientsManager' => array('className' => 'ClientsManager',
            'foreignKey' => 'client_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'ClientsMemo' => array('className' => 'ClientsMemo',
            'foreignKey' => 'client_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'date DESC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'ClientsCheck' => array('className' => 'ClientsCheck',
            'foreignKey' => 'client_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'ClientsSearch' => array('className' => 'ClientsSearch',
            'foreignKey' => 'client_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
    );
    var $validate = array(
        'name' => array('notempty'),
        'city' => array('notempty'),
        'state_id' => array('notempty'),
        'zip' => array('notempty'),
    );
    function beforeSave() {
        $this->data['Client']['modified_date'] = date('Y-m-d H:m:s');
        return true;
    }

    //
    public function __construct() {
        $this->dsComp = new DatasourcesComponent;
        $this->xml_home = Configure::read('xml_home');
        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->statementsComp = new StatementsComponent;

        $this->jsonComp = new JsonComponent;
        $this->dateF = new DateFunctionComponent();


        #
        # BAD IDEA WHEN WRITING XML FILES
        #
        #$this->doc = new DOMDocument('1.0');
        #$this->doc->formatOutput = true;

        parent::__construct();
    }
    function general_info($id = null) {
        $this->recursive = 0;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck'),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->data = $this->read(null, $id);
        $this->data['Client']['state']= $this->data['State']['name'];
        return ($this->data);
    }
    function invoices($id = null) {
        App::import('Component', 'DateFunction');
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->ClientsCheck->InvoicesPayment->unbindModel(array('belongsTo' => array('Invoice','ClientsCheck'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsManager','ClientsMemo','ClientsSearch',),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);

        $this->ClientsContract->Invoice->bindModel(array('belongsTo' => array('ClientsContract'=> array('className' => 'ClientsContract',
            'foreignKey' => 'contract_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('hasMany' => array('ContractsItem'),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('User'),),false);
        $this->data = $this->read(null, $id);
        $this->ClientsContract->Invoice->recursive = 2;
        $invoices = $this->ClientsContract->Invoice->find('all',
            array('order' =>'date DESC',
                'conditions'=>array('ClientsContract.client_id'=>$id,
                    'Invoice.voided'=>0,'Invoice.posted'=>1,'Invoice.cleared'=>0,'Invoice.amount > 0'),
                array('order'=>array('date desc'))
            ));
        $count = 0;
        foreach ($invoices as $invoice):
            if(!$invoice['Invoice']['cleared'] && !$invoice['Invoice']['voided']) # only go through expense of calculating 'cleared' or 'pastdue' if not cleared
            {
                if(!$this->ClientsContract->Invoice->set_invoice_clear_status($invoice['Invoice']['id'])) # trigger to set cleared state, only recalculate if not cleared
                {
                    $employee =  $this->ClientsContract->Invoice->employeeForInvoicing($invoice['ClientsContract']['employee_id']);
                    $invoices[$count]['Invoice']['urlslug'] = $this->ClientsContract->Invoice->invoice_slug($invoice, $employee);
                    $datearray = getdate(strtotime($invoice['Invoice']['date']));
                    $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
                    $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
                    $invoices[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
                    $invoices[$count]['Invoice']['dayspast'] = $this->dateF->dateDiff(date('Y-m-d',$duedate),date('Y-m-d',$today));

                    $amount_paid = 0;
                    foreach($invoice['InvoicesPayment'] as $payment):
                        $amount_paid += $payment['amount'];
                    endforeach;
                    $invoices[$count]['Invoice']['balance'] = $invoices[$count]['Invoice']['amount'] - $amount_paid;
                    $invoices[$count]['Invoice']['payments'] = $amount_paid;

                    if ($duedate < mktime(0, 0, 0, date("m")  , date("d"), date("Y")))
                    {
                        $invoices[$count]['Invoice']['pastdue'] = 1;					} else
                    {
                        $invoices[$count]['Invoice']['pastdue'] = 0;
                    }
                }
                else
                {
                    $invoices[$count]['Invoice']['pastdue'] = 0;;
                }
            }
            $count++;
        endforeach;
        $this->data['Invoice'] = $invoices;
        return ($this->data);
    }

    function get_cached_client($filename)
    {
        $payload = array();
        $fsize = filesize($filename);
        if($fsize)
        {
            $domSrc = file_get_contents($filename);

            $doc = new DOMDocument('1.0');
            $doc->formatOutput = true;
            $doc->loadXML( $domSrc );
            // load up company name and state name
            $names = $doc->getElementsByTagName('name');
            $clnameO = $names->item(0);

            $payload['name'] = $clnameO->nodeValue;

            $states = $doc->getElementsByTagName('state');

            $clstateO = $states->item(0);
            $payload['state'] = $clstateO->nodeValue;
            // load up address
            $id = $doc->getElementsByTagName('id');
            $street1 = $doc->getElementsByTagName('street1');
            $street2 = $doc->getElementsByTagName('street2');
            $city = $doc->getElementsByTagName('city');
            $zip = $doc->getElementsByTagName('zip');
            $active = $doc->getElementsByTagName('active');
            // node objects
            $idO = $id->item(0);
            $street1O = $street1->item(0);
            $street2P = $street2->item(0);
            $cityO = $city->item(0);
            $zipO = $zip->item(0);
            $activeO =$active->item(0);

            $payload['id'] = $idO->nodeValue;
            $payload['street1'] = $street1O->nodeValue;
            $payload['street2'] = $street2P->nodeValue;
            $payload['city'] = $cityO->nodeValue;
            $payload['zip'] = $zipO->nodeValue;
            $payload['active'] = $activeO->nodeValue;
            //Return the links
            return $payload;
        }
        else
        {
            print 'XML file is empty.';
        }
        return $payload;
    }
    function get_transaction_opens_array($filename)
    {
        $payload = array();
        $payload['Invoice'] = array();
        $payload['Check'] = array();
        $fsize = filesize($filename);
        if($fsize)
        {
            $domSrc = file_get_contents($filename);

            $doc = new DOMDocument('1.0');
            $doc->formatOutput = true;
            $doc->loadXML( $domSrc );
            // load up client_id
            $client_id = $doc->getElementsByTagName('client_id');
            $client_idO = $client_id->item(0);
            $payload['client_id'] = $client_idO->nodeValue;
            // load up generated date
            $date = $doc->getElementsByTagName('date_generated');
            $dateO = $date->item(0);
            $payload['date_generated'] = $dateO->nodeValue;
            // load up invoices
            $invs = $doc->getElementsByTagName('invoice');
            foreach ($invs as $inv) {
                $payload['Invoice'][] = $inv->nodeValue;
            }
            //Return the links
            return $payload;
        }
        else
        {
            print 'XML file is empty.';
        }
        return $payload;
    }
    private function append_new_transactions_to_statement_array($payload,$invoicesdb, $checksdb)
    {
        $newpayload = array();
        $newpayload['Invoice'] = array();
        $newpayload['Check'] = array();
        // recollect previous invoices
        if(!empty($payload['Invoice']['XML_Serializer_Tag']) )
        {
            $inv_count = count($payload['Invoice']['XML_Serializer_Tag']);
            foreach ($payload['Invoice']['XML_Serializer_Tag'] as $inv)
            {
                // remove phoney invoice
                if ($inv != 0  )
                {
                    $newpayload['Invoice'][] = $inv;
                } else if ($inv_count == 1){
                    $newpayload['Invoice'][] = $inv;
                }
            }
        }
        // recollect previous checks
        if(!empty($payload['Check']['XML_Serializer_Tag']))
        {
            $inv_count = count($payload['Check']['XML_Serializer_Tag']);
            foreach ($payload['Check']['XML_Serializer_Tag'] as $inv)
            {
                // remove phoney check
                if ($inv != 0  )
                {
                    $newpayload['Check'][] = $inv;
                } else if ($inv_count == 1){
                    $newpayload['Check'][] = $inv;
                }
            }
        }
        // add new invoices to statement
        foreach ($invoicesdb['Invoice'] as $inv)
        {
            if(!in_array($inv,$newpayload['Invoice']))
            {
                $newpayload['Invoice'][] = $inv;
            }
        }
        // add new invoices to statement
        foreach ($checksdb['Check'] as $ck)
        {
            if(!in_array($ck,$newpayload['Check']))
            {
                $newpayload['Check'][] = $ck;
            }
        }
        return $newpayload;
    }

    function opening_invoices($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->ClientsCheck->InvoicesPayment->unbindModel(array('belongsTo' => array('Invoice','ClientsCheck'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsManager','ClientsMemo','ClientsSearch',),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('hasMany' => array('ContractsItem'),),false);
        $this->ClientsContract->Invoice->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('User'),),false);
        $this->data = $this->read(null, $id);
        $this->ClientsContract->Invoice->recursive = 2;

        App::import('Model', 'InvoicesOpening');
        $oinvoiceM = new InvoicesOpening;;
        $oinvoices = $oinvoiceM->find('all',Null);
        $count = 0;
        foreach($oinvoices as $oinv)
        {
            $inv = $this->ClientsContract->Invoice->read(Null,$oinv['InvoicesOpening']['invoice_id']);
            $oinvoices[$count]['Invoice']['duedate'] = date('Y-m-d');
            $oinvoices[$count]['ClientsContract'] = $inv['ClientsContract'];
            $count++;
        }
        $this->data['Invoice'] = $oinvoices;
        return ($this->data);
    }
    /*
     * collects primary keys of client's checks
     */
    private function checks_all($id = null)
    {

        $checks = Array();
        $checksDB = $this->ClientsCheck->find('all',array('conditions'=>array('client_id'=>$id)));
        foreach ($checksDB as $check)
        {
            // set cleared [4] and voided [7] to zero
            $checks [] = $check['ClientsCheck']['id'];
        }
        return $checks;
    }
    function invoices_pending($id = null) {

        $invoices = $this->ClientsContract->Invoice->clientsPendingInvoices($id);
        $count = 0;
        foreach ($invoices as $invoice):
            if(!$invoice['Invoice']['cleared'] && !$invoice['Invoice']['voided']) # only go through expense of calculating 'cleared' or 'pastdue' if not cleared
            {
                if(!$this->ClientsContract->Invoice->set_invoice_clear_status($invoice['Invoice']['id'])) # trigger to set cleared state, only recalculate if not cleared
                {
                    $datearray = getdate(strtotime($invoice['Invoice']['date']));
                    $duedate  = mktime(0, 0, 0,  date('m',strtotime($datearray['month'])) , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
                    $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
                    $invoices[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
                    $invoices[$count]['Invoice']['dayspast'] = $this->dateF->dateDiff(date('Y-m-d',$duedate),date('Y-m-d',$today));
                    if ($duedate < mktime(0, 0, 0, date("m")  , date("d"), date("Y")))
                    {
                        $invoices[$count]['Invoice']['pastdue'] = 1;
                        $amount_paid = 0;
                        foreach($invoice['InvoicesPayment'] as $payment):
                            $amount_paid += $payment['amount'];
                        endforeach;
                        $invoices[$count]['Invoice']['balance'] = $invoices[$count]['Invoice']['amount'] - $amount_paid;
                        $invoices[$count]['Invoice']['payments'] = $amount_paid;
                    } else
                    {
                        $invoices[$count]['Invoice']['pastdue'] = 0;
                    }
                }
                else
                {
                    $invoices[$count]['Invoice']['pastdue'] = 0;;
                }
            }
            $count++;
        endforeach;
        $this->data['Invoice'] = $invoices;
        //debug($this->data);//exit;
        return ($this->data);
    }
    function searches($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsSearch->unbindModel(array('hasAndBelongsToMany' => array('Resume'),),false);
        $this->ClientsSearch->unbindModel(array('belongsTo' => array('Client'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsManager','ClientsMemo',),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->data = $this->read(null, $id);
        //debug($this->data);exit;
        return ($this->data);
    }
    function memos($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsManager','ClientsSearch',),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->data = $this->read(null, $id);
        //debug($this->data);exit;
        return ($this->data);
    }
    function managers($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsManager->unbindModel(array('belongsTo' => array('Client'),),false);
        $this->ClientsManager->unbindModel(array('hasAndBelongsToMany' => array('ClientsContracts'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsSearch','ClientsMemo','Invoices'),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->data = $this->read(null, $id);
        //debug($this->data);exit;
        return ($this->data);
    }
    function contracts($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->bindModel(array('hasMany' => array('ClientsContract'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsManager','ClientsMemo','ClientsSearch'),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $contracts = $this->read(array('name','street1','street2','city','state_id','zip','active','hq'), $id);

        return ($contracts);
    }

    function contracts_inactive($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsManager','ClientsMemo','ClientsSearch'),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        //$this->data = $this->read(array('name','street1','street2','city','state_id','zip','active','hq'), $id);

        $this->data['ClientsContract'] = $this->ClientsContract->find('all', array('conditions'=>
            array('client_id'=>$id), 'order' => 'ClientsContract.enddate desc'));

        //read(array('name','street1','street2','city','state_id','zip','active','hq'), $id);
        //debug ($this->data);exit;
        return ($this->data);
    }
    function contracts_ytd($id = null) {
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        //$this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck','ClientsManager','ClientsMemo','ClientsSearch'),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->data = $this->read(array('name','street1','street2','city','state_id','zip','active'), $id);
        $i = 0;
        foreach ($this->data['ClientsContract'] as $contract)
        {

            $j = 0;
            foreach ($contract['Invoice'] as $invoice)
            {
                //debug($invoice);
                if($invoice['cleared']==1 && $invoice['voided']==0)
                {
                    $payments = $this->ClientsContract->Invoice->InvoicesPayment->find('all',array('conditions'=>array('invoice_id'=>
                        $invoice['id'])));
                    //debug($payments);//exit;
                    $paymentA = array();
                    if(isset($payments[0]['InvoicesPayment']['check_id']))
                    {
                        $check = $this->ClientsContract->Invoice->InvoicesPayment->ClientsCheck->read(null, $payments[0]['InvoicesPayment']['check_id']);

                        //debug($check);exit;
                        //$paymentA['paid_date']= $check['ClientsCheck']['date'];
                        $this->data['ClientsContract'][$i]['Invoice'][$j]['paid_date']=$check['ClientsCheck']['date'];
                    } else {
                        $this->data['ClientsContract'][$i]['Invoice'][$j]['paid_date']= NULL;
                    }
                } else
                {
                    $this->data['ClientsContract'][$i]['Invoice'][$j]['paid_date']= NULL;
                }
                $j++;
            }
            $i++;
        }
        //debug ($this->data);exit;
        return ($this->data);
    }
    function checks($id = null) {
        $this->recursive = 0;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->Invoice->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment',
            'EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->unbindModel(array('hasMany' => array('ClientsCheck'),),false);
        $this->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);

        $this->data = $this->read(null, $id);
        $this->data['ClientsCheck'] = array();
        $checks = $this->ClientsCheck->find('all', array('order' =>'date DESC','conditions'=>array('client_id'=>$id)));
        foreach($checks as $check):
            $this->data['ClientsCheck'][] = $check['ClientsCheck'];
        endforeach;
        return ($this->data);
    }
    function clientforcontractbuild($id)
    {
        $this->unbindModel(array('hasMany' =>
            array('Invoice',
                'ClientsContract',
                'ClientsManager',
                'ClientsMemo',
                'ClientsCheck',
                'ClientsSearch',
            ),),false);

        $this->ClientsContract->unbindModel(array('hasMany' => array(
            'Invoice',
            'ContractsItem',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
            'ClientsManager'
        ),),false);
        return $this->read(null, $id);
    }

    function active_jumpto_menu()
    {

        $clientsMenu = array();
        $this->unbindModel(array('belongsTo' => array(
            'Note',
            'State',
            'InvoicesItemsCommissionsItem',
        ),),false);
        $this->unbindModel(array('hasMany' => array(
            'ClientsContract',
            'ClientsManager',
            'ClientsMemo',
            'ClientsCheck',
            'ClientsSearch',
            'EmployeesEmail',
            'EmployeesPayment',
            'CommissionsPayment',
            'NotesPayment',
            'Note',
            'Expense',
        ),),false);

        $clients = $this->find('all',array('conditions'=>array(
            'active'=>1,
        ),
            'order'=> array('name'=>'ASC'),
        ));
        foreach ($clients as $client)
        {
            $clientsMenu[$client['Client']['id']] = $client['Client']['name'];
        }
        return $clientsMenu;
    }

    function completeList()
    {
        $clientsAll = $this->find('all',array('conditions'=>
            array(
                'Client.active' => 1,
            )));
        $clientslist = array();
        foreach ($clientsAll as $client):
            array_push($clientslist, $client['Client']['id']);
        endforeach;
        //debug($employeeslist);exit;
        return $clientslist;
    }

}
?>
