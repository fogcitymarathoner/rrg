<?php

App::import('Component', 'Json');
App::import('Component', 'Commissions');
App::import('Component', 'Xml');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'InvoiceFunction');


App::import('Model', 'ClientsContract');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsReportsTag');
App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');


class InvoicesItem extends AppModel {

	var $name = 'InvoicesItem';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Invoice' => array('className' => 'Invoice',
								'foreignKey' => 'invoice_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	var $hasMany = array(
			'InvoicesItemsCommissionsItem' => array('className' => 'InvoicesItemsCommissionsItem',
								'foreignKey' => 'invoices_item_id',
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
			
	);

	public function __construct() {

		$this->xmlComp = new XmlComponent;
		$this->dirComp = new FixtureDirectoriesComponent;

		$this->invoiceFunction = new InvoiceFunctionComponent;
		$this->hu = new HashUtilsComponent;
		$this->commsComp = new CommissionsComponent;
		$this->dirComp = new FixtureDirectoriesComponent;
		$this->dsComp = new DatasourcesComponent;
		$this->xml_home = Configure::read('xml_home');
		$this->CommissionsReportsTag = new CommissionsReportsTag;

		parent::__construct();
	}

	// delete items created from invoices that have been deleted
    function delete_orphan_items()
    {
        echo "Deleting orphan Invoice Items\n";
        $nintyDaysback = mktime(0, 0, 0, date("m")  , date("d")-90, date("Y"));
        $str90 = date("Y-m-d",$nintyDaysback);
        echo '  starting '.$str90."\n";
        $this->recursive = 1;
        $this->data = $this->find('all',Null);
        foreach ($this->data as $item):

            if (!$item['Invoice']['id'])
            {
                $this->delete($item['InvoicesItem']['id']);
            }

        endforeach;

    }

}
?>