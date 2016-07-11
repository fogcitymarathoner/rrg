<?php

App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'FixtureDirectories');

class CommissionsPayment extends AppModel {
	var $name = 'CommissionsPayment';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

	);
	var $hasOne = array(
		'Note' => array(
			'className' => 'Note',
			'foreignKey' => 'commissions_payment_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


    public function __construct() {
        $this->dsComp = new DatasourcesComponent;
        $this->xml_home = Configure::read('xml_home');
        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->hu = new HashUtilsComponent;

        parent::__construct();
    }
}
?>