<?php


App::import('Component', 'Json');
App::import('Component', 'Datasources');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'Statements');
App::import('Component', 'DateFunction');

class Expense extends AppModel {

	var $name = 'Expense';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'ExpensesCategory' => array('className' => 'ExpensesCategory',
								'foreignKey' => 'category_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Employee' => array('className' => 'Employee',
								'foreignKey' => 'employee_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
	);

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
        parent::__construct();
    }
    function beforeSave() {
        $this->data['Expense']['modified_date'] = date('Y-m-d H:m:s');

        if(isset($this->data['Expense']['date']) && $this->data['Expense']['date'] != Null)
        {

            if(substr_count($this->data['Expense']['date'],'/'))
            {
                $dateA = explode('/',$this->data['Expense']['date']);
                $this->data['Expense']['date'] =$dateA[2].'-'.$dateA[0].'-'.$dateA[1];
            }
            if(substr_count($this->data['Expense']['date'],'-'))
            {
                $dateA = explode('-',$this->data['Expense']['date']);
                $this->data['Expense']['date'] =$dateA[0].'-'.$dateA[1].'-'.$dateA[2];
            }
        }
        return true;
    }
}
?>