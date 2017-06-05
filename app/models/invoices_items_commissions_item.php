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
App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');

class InvoicesItemsCommissionsItem extends AppModel {

	var $name = 'InvoicesItemsCommissionsItem';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InvoicesItem' => array(
			'className' => 'InvoicesItem',
			'foreignKey' => 'invoices_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CommissionsReport' => array(
			'className' => 'CommissionsReport',
			'foreignKey' => 'commissions_report_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    static $xmlComp;
    static $dirComp;

    static $invoiceFunction;
    static $hu;
    static $commsComp;
    static $dsComp;
    static $xml_home;
    public function init() {

        self::$xmlComp = new XmlComponent;
        self::$dirComp = new FixtureDirectoriesComponent;

        self::$invoiceFunction = new InvoiceFunctionComponent;
        self::$hu = new HashUtilsComponent;
        self::$commsComp = new CommissionsComponent;
        self::$dsComp = new DatasourcesComponent;
        self::$xml_home = Configure::read('xml_home');

    }

	/* called from radio buttons in reminders index */
	function soap_void($id,$updown) {
		if (!$id || !$updown) {
			$this->Session->setFlash(__('Invalid Invoice Commissions Item', true));
			$this->redirect(array('action'=>'index'));
		}
		$invoicecommitem['id'] = $id;
		$invoicecommitem['voided'] = $updown;
		$this->InvoicesItemsCommissionsItem->save($invoicecommitem);
		$this->redirect(array('action'=>'index'));
	}
    function invoice_id($id) {
        $inv_comm_item = $this->read(null,$id);
        $inv_item = $this->InvoicesItem->read(null,$inv_comm_item['InvoicesItemsCommissionsItem']['invoices_item_id']);
        return($inv_item['InvoicesItem']['invoice_id']);
    }
    function clear_commissions_items()
    {
        echo 'Clearing commissions items connected to cleared invoices';
        $this->recursive = 0;
        $uncleared = $this->find('all',array('conditions'=>array('InvoicesItemsCommissionsItem.cleared' => 0)));
        foreach($uncleared as $i)
        {
            $inv = $this->InvoicesItem->Invoice->read(null,$i['InvoicesItem']['invoice_id']);
            if($inv['Invoice']['cleared'] && !$i['InvoicesItemsCommissionsItem']['cleared'])
            {
                $i['InvoicesItemsCommissionsItem']['cleared'] = 1;
                $this->save($i);
            }

            if($inv['Invoice']['cleared'] && !$i['InvoicesItem']['cleared'])
            {
                $i['InvoicesItem']['cleared'] = 1;
                $this->InvoicesItem->save($i);
            }
        }
    }

}


InvoicesItemsCommissionsItem::init();
?>
