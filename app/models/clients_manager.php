<?php
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
class ClientsManager extends AppModel {
	var $name = 'ClientsManager';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasAndBelongsToMany = array(
    		'ClientsContract' => array(
			'className' => 'ClientsContract',
			'joinTable' => 'contracts_managers',
			'foreignKey' => 'manager_id',
			'associationForeignKey' => 'contract_id',
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
    public function __construct() {
        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->jsonComp = new JsonComponent;
        $this->xml_home = Configure::read('xml_home');
        parent::__construct();
    }
	function beforeSave() {
    	$this->data['ClientsManager']['modified_date'] = date('Y-m-d H:m:s');
		return true;
	}	
	
}
?>