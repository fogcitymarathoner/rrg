<?php

App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');

class ClientsCheck extends AppModel {

	var $name = 'ClientsCheck';
	var $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	var $hasMany = array(
		'InvoicesPayment' => array(
			'className' => 'InvoicesPayment',
			'foreignKey' => 'check_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'ordering asc',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	
	var $validate = array(
		'number' => array('notempty'),
		'amount' => array('notempty')
	);


    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->xml_home = Configure::read('xml_home');

        parent::__construct();
    }
	function beforeSave()
	{
        $pos = strpos($this->data['ClientsCheck']['date'],'-');
        if($pos === False)
        {
            $date_explode = explode('/',$this->data['ClientsCheck']['date']);
		    $this->data['ClientsCheck']['date']=$date_explode[2].'-'.$date_explode[0].'-'.$date_explode[1];
        }
        $paytotal=0;
        if(isset($this->data['Invoice'])) //Should only calculate total from add_check routine/ delete otherwise
        {
            if($pos === False)
            {
                foreach ($this->data['Invoice']['InvoiceAmount'] as $pay):
                    $paytotal += $pay['amount'];
                endforeach;
                $this->data['ClientsCheck']['amount'] = $paytotal;
            }
        }
        return true;
	} 
	function checkforpaymentreview($id)
	{		
		$this->recursive = 2;
		$this->unbindModel(array('belongsTo' => array('Client'),),false);
        $this->InvoicesPayment->unbindModel(array('belongsTo' => array('ClientsCheck'),),false);
        $check = $this->read(null, $id);
        $total = 0;
        foreach($check['InvoicesPayment'] as $pay)
        {
            $total += $pay['amount'];
        }
        $check['ClientsCheck']['amount']=$total;
        // update amount of check
        $this->save($check);
		return $check;
	}
}
?>
