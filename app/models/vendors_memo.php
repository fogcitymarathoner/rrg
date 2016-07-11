<?php
App::import('Core', 'Security');
App::import('Component', 'Json');
App::import('Component', 'Xml');
App::import('Component', 'RrgString');
App::import('Component', 'HashUtils');
App::import('Model', 'CommissionsReport');


App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Component', 'Datasources');
App::import('Component', 'Commissions');
App::import('Component', 'FixtureDirectories');


class VendorsMemo extends AppModel {

	var $name = 'VendorsMemo';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Vendor' => array('className' => 'Vendor',
								'foreignKey' => 'vendor_id',
								'conditions' => '',
								'fields' => '',
								'order' => 'date desc'
			)
	);
	public function __construct() {
		$this->xml_home = Configure::read('xml_home');
		$this->xmlComp = new XmlComponent;
		$this->dirComp = new FixtureDirectoriesComponent;
		$this->jsonComp = new JsonComponent;
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