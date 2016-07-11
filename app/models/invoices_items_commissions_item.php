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
    static $CommissionsReportsTag;
    public function init() {

        self::$xmlComp = new XmlComponent;
        self::$dirComp = new FixtureDirectoriesComponent;

        self::$invoiceFunction = new InvoiceFunctionComponent;
        self::$hu = new HashUtilsComponent;
        self::$commsComp = new CommissionsComponent;
        self::$dsComp = new DatasourcesComponent;
        self::$xml_home = Configure::read('xml_home');
        self::$CommissionsReportsTag = new CommissionsReportsTag;

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

    function fix_commitems()
    {
        $items = $this->find('all',Null);
        foreach($items as $item)
        {
            //debug($item['InvoicesItemsCommissionsItem']);
            $emp_id = $item['InvoicesItemsCommissionsItem']['employee_id'];
            //debug($item['InvoicesItemsCommissionsItem']['employee_id']);
            //debug($item['InvoicesItem']);
            //debug($item['InvoicesItem']['invoice_id']);
            $this->InvoicesItem->Invoice->recursive = 2;
            $inv = $this->InvoicesItem->Invoice->read(Null, $item['InvoicesItem']['invoice_id']);
            //debug($inv);//exit;
            $rel_inv_amt = 0 ;
            foreach($inv['InvoicesItem'] as $Iitem)
            {
                foreach ($Iitem['InvoicesItemsCommissionsItem'] as $commitem)
                {//debug($commitem);
                    if($commitem['employee_id']== $emp_id && !$commitem['voided'])
                    {
                        //debug($commitem);

                        $rel_inv_amt += $commitem['rel_item_amt']*$commitem['rel_item_quantity'];
                    }
                }
            }
            //debug($rel_inv_amt);
            $item['InvoicesItemsCommissionsItem']['rel_inv_amt']= $rel_inv_amt;
            $this->save($item);
        }
            }

}


InvoicesItemsCommissionsItem::init();
?>