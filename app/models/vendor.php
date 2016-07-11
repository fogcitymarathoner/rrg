<?php

App::import('Component', 'Json');
App::import('Component', 'Datasources');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'Statements');
App::import('Component', 'DateFunction');

class Vendor extends AppModel {

	var $name = 'Vendor';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'State' => array('className' => 'State',
								'foreignKey' => 'state_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
	);

    var $actsAs = array('Cipher' => array('cipher' => array('secretbits')));
	var $hasMany = array(
			'VendorsMemo' => array('className' => 'VendorsMemo',
								'foreignKey' => 'vendor_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => 'date desc',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

	public function __construct() {
		$this->dsComp = new DatasourcesComponent;
		$this->xml_home = Configure::read('xml_home');
		$this->xmlComp = new XmlComponent;
		$this->dirComp = new FixtureDirectoriesComponent;
		$this->statementsComp = new StatementsComponent;

		$this->jsonComp = new JsonComponent;
		$this->dateF = new DateFunctionComponent();
		$this->vendorsmemosdir = $this->xml_home.'vendors_memos/';
		#
		# BAD IDEA WHEN WRITING XML FILES
		#
		#$this->doc = new DOMDocument('1.0');
		#$this->doc->formatOutput = true;

		parent::__construct();
	}

}
?>