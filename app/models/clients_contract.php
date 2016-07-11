<?php

App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'TokenHelper');

class ClientsContract extends AppModel {
	var $name = 'ClientsContract';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Period' => array(
			'className' => 'Period',
			'foreignKey' => 'period_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasMany = array(
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'contract_id',
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
		'ContractsItem' => array(
			'className' => 'ContractsItem',
			'foreignKey' => 'contract_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'ordering ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	var $hasAndBelongsToMany = array(
		'ClientsManager' => array(
			'className' => 'ClientsManager',
			'joinTable' => 'contracts_managers',
			'foreignKey' => 'contract_id',
			'associationForeignKey' => 'manager_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'User' => array(
			'className' => 'User',
			'joinTable' => 'contracts_users',
			'foreignKey' => 'contract_id',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	var $validate = array(
       'client_id' => 'notEmpty',
       'employee_id' => 'notEmpty',
	
		//'startdate' => array('rule' => array('date', 'ymd')),
					
	);

    public function __construct() {
        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->xml_home = Configure::read('xml_home');
        $this->Tk = new TokenHelperComponent;
        parent::__construct();
    }
	function beforeSave() { //debug($this);
		if(isset($this->data['ClientsContract']['startdate']) && strpos($this->data['ClientsContract']['startdate'],'/') )
		{
			$datearray = explode('/',$this->data['ClientsContract']['startdate']);
			$this->data['ClientsContract']['startdate'] = $datearray[2].'-'.$datearray[0].'-'.$datearray[1];
		}
		if(isset($this->data['ClientsContract']['enddate']) &&$this->data['ClientsContract']['enddate']!= null)
		{
			if ($this->data['ClientsContract']['enddate'] == '0000-00-00' || $this->data['ClientsContract']['enddate'] == '00/00/0000' )
			{
				$this->data['ClientsContract']['enddate'] = NULL;
			} else {
				$datearray = explode('/',$this->data['ClientsContract']['enddate']);
				$this->data['ClientsContract']['enddate'] = $datearray[2].'-'.$datearray[0].'-'.$datearray[1];
			}
		}
    	$this->data['ClientsContract']['modified_date'] = date('Y-m-d H:m:s');
		return true;
	}	
	function delete($id)
	{
		$contract = $this->read(null,$id);
		$this->Invoice->delete($contract['ClientsContract']['mock_invoice_id']);
		parent::delete($id);
	}
	function add($contract)
	{
		

		$token = $this->Tk->generatePassword();
		$this->create();
		;			
		if ($this->save($contract)) {
					
				$contractID = $this->getLastInsertID();
				$this->log('The Contact '.$contractID.' has been saved', 'debug');	
				$invoice['Invoice']['contract_id'] = $contractID;
				$invoice['Invoice']['terms'] = $contract['ClientsContract']['terms'];
				$invoice['Invoice']['employerexpenserate'] = $contract['ClientsContract']['employerexp'];
				
				$invoice['Invoice']['date'] = date("Y-m-d");
				$invoice['Invoice']['period_start'] = date("Y-m-d");
				$invoice['Invoice']['period_end'] = date("Y-m-d");
				$invoice['Invoice']['mock'] = 1;
				
				$invoice['Invoice']['created_date'] = date('Y-m-d');	
				$invoice['Invoice']['token'] = $token;
				$invoice['Invoice']['view_count'] = 0;
				$invoice['Invoice']['voided'] = 1;		
				$user = 1;
				$invoice['Invoice']['modified_user_id'] = $contract['ClientsContract']['created_user_id'];
				$invoice['Invoice']['created_user_id'] = $contract['ClientsContract']['created_user_id'];
				$this->Invoice->create();
				if ($this->Invoice->save($invoice)) {
					$invID = $this->Invoice->getLastInsertID();
					$this->log('The Mock Invoice '.$invID.' has been saved', 'debug');
					$contract['ClientsContract']['mock_invoice_id'] = $invID;
					if ($this->save($contract)) {
						
						$this->log('The Mock Invoice '.$invID.'has been recorded in the contract '.$contractID, 'debug');	
						return $contractID; 
					} else {
						$this->log('The Mock Invoice could not be recorded in the contract', 'debug');
						return 99;
					}
				} else {
					$this->log('The Mock Invoice could not be saved. Please, try again.', 'debug');
					return 99;
				}
			} else {
				$this->log('The Contract could not be saved. Please, try again.', 'debug');
				return 99;
			}
	}
	function clientcontract_mock_invoice_manage($id)
	{
        $this->unbindModel(array('hasMany' => array('Invoice',
            'ContractsItem',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
            'ClientsManager'
        ),),false);
		return $this->read(null,$id);
	}
	function client($id)
	{
        $this->recursive = 1;
        $this->bindModel(array('belongsTo' => array('Client','Employee'),),false);
		return $this->read(null,$id);
	}
	function reviewInfo($id)
	{
		;
	}
}
?>