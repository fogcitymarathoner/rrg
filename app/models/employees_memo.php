<?php
class EmployeesMemo extends AppModel {

	var $name = 'EmployeesMemo';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Employee' => array('className' => 'Employee',
								'foreignKey' => 'employee_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	public function __construct() {

		$this->xmlComp = new XmlComponent;
		$this->dirComp = new FixtureDirectoriesComponent;

		$this->hu = new HashUtilsComponent;
		$this->commsComp = new CommissionsComponent;
		$this->dsComp = new DatasourcesComponent;
		$this->xml_home = Configure::read('xml_home');


		$this->xmlComp = new XmlComponent;

		parent::__construct();
	}
}
?>