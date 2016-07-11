<?php

App::import('Component', 'Xml');
App::import('Component', 'Json');

App::import('Component', 'FixtureDirectories');
class ClientsMemo extends AppModel {

	var $name = 'ClientsMemo';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Client' => array('className' => 'Client',
								'foreignKey' => 'client_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
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
    	$this->data['ClientsMemo']['modified_date'] = date('Y-m-d H:m:s');
		return true;
	}	
}
?>