<?php


App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');

class ContractsItem extends AppModel {

	var $name = 'ContractsItem';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'ClientsContract' => array('className' => 'ClientsContract',
								'foreignKey' => 'contract_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			
	);
	var $hasMany = array(
			'ContractsItemsCommissionsItem' => array('className' => 'ContractsItemsCommissionsItem',
								'foreignKey' => 'contracts_items_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => '')
	);

    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->xml_home = Configure::read('xml_home');

        parent::__construct();
    }
	function beforeSave() { 
    	$this->data['ContractsItem']['modified_date'] = date('Y-m-d H:m:s');
		return true;
	}
    function auto_add_items($contract_id,$cost,$user) {
        //debug($this->data);exit;
        if ($cost == null && $contract_id== null)
        {
            return False;
        } else
        {
            if ($contract_id && $cost)
            { 	//debug($this->data);exit;
                $item = array();
                $item['ContractsItem']['created_date'] = date('Y-m-d');
                $item['ContractsItem']['modified_date'] = date('Y-m-d H:m:s');
                $item['ContractsItem']['description'] = 'Regular';
                $item['ContractsItem']['contract_id'] = $contract_id;
                $item['ContractsItem']['active'] = 1;
                $item['ContractsItem']['ordering'] = 1;
                $item['ContractsItem']['cost'] = $cost;
                $amt = $cost*1.35;
                $item['ContractsItem']['amt'] = $amt;
                $item['ContractsItem']['created_user_id'] =$user['User']['id'];
                $item['ContractsItem']['modified_user_id'] =$user['User']['id'];
                $commitem = array();
                $commitem['ContractsItemsCommissionsItem']['created_date'] = date('Y-m-d');
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['created_user_id'] =$user['User']['id'];
                $commitem['ContractsItemsCommissionsItem']['modified_user_id'] =$user['User']['id'];
                $this->create();
                $this->save($item);

                $item_id = $this->getLastInsertID ();
                // Regular
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =61.50;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1025;

                //debug($this->data);exit;
                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);


                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');

                $commitem['ContractsItemsCommissionsItem']['percent'] =38.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1479;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);


                $item['ContractsItem']['description'] = 'Overtime';
                $item['ContractsItem']['ordering'] = 2;
                $item['ContractsItem']['active'] = 1;
                $item['ContractsItem']['cost'] = $cost*1.5;
                $item['ContractsItem']['amt'] = $amt*1.5;

                $this->create();
                $this->save($item);

                $item_id = $this->getLastInsertID ();


                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =61.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1025;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);
                // GOOD
                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =38.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1479;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);
                ///
                $item['ContractsItem']['description'] = 'Double Time';
                $item['ContractsItem']['active'] = 1;
                $item['ContractsItem']['ordering'] = 2;
                $item['ContractsItem']['cost'] = $cost*2;
                $item['ContractsItem']['amt'] = $amt*2;

                $this->create();
                $this->save($item);

                $item_id = $this->getLastInsertID ();

                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =61.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1025;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);


                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =38.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1479;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);
                return True;
            }
        }

    }

    function auto_add_items_method2($contract_id,$cost,$user,$amount) {
        //debug($this->data);exit;
        if ($cost == null && $contract_id== null && $amount== null)
        {
            return False;
        } else
        {
            if ($contract_id && $cost && $amount)
            { 	//debug($this->data);exit;
                $percent_markup =  round($amount/$cost);
                $item = array();
                $item['ContractsItem']['created_date'] = date('Y-m-d');
                $item['ContractsItem']['modified_date'] = date('Y-m-d H:m:s');
                $item['ContractsItem']['description'] = 'Regular';
                $item['ContractsItem']['contract_id'] = $contract_id;
                $item['ContractsItem']['active'] = 1;
                $item['ContractsItem']['ordering'] = 1;
                $item['ContractsItem']['cost'] = $cost;
                //$amt = $cost*1.35;
                $item['ContractsItem']['amt'] = $amount;
                $amt = $item['ContractsItem']['amt'];
                $item['ContractsItem']['created_user_id'] =$user['User']['id'];
                $item['ContractsItem']['modified_user_id'] =$user['User']['id'];
                $commitem = array();
                $commitem['ContractsItemsCommissionsItem']['created_date'] = date('Y-m-d');
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['created_user_id'] =$user['User']['id'];
                $commitem['ContractsItemsCommissionsItem']['modified_user_id'] =$user['User']['id'];
                $this->create();
                $this->save($item);

                $item_id = $this->getLastInsertID ();
                // Regular
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =61.50;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1025;

                //debug($this->data);exit;
                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);


                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');

                $commitem['ContractsItemsCommissionsItem']['percent'] =38.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1479;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);


                $item['ContractsItem']['description'] = 'Overtime';
                $item['ContractsItem']['ordering'] = 2;
                $item['ContractsItem']['active'] = 1;
                $item['ContractsItem']['cost'] = $cost*1.5;
                $item['ContractsItem']['amt'] = $amt*1.5;

                $this->create();
                $this->save($item);

                $item_id = $this->getLastInsertID ();


                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =61.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1025;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);
                // GOOD
                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =38.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1479;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);
                ///
                $item['ContractsItem']['description'] = 'Double Time';
                $item['ContractsItem']['active'] = 1;
                $item['ContractsItem']['ordering'] = 2;
                $item['ContractsItem']['cost'] = $cost*2;
                $item['ContractsItem']['amt'] = $amt*2;

                $this->create();
                $this->save($item);

                $item_id = $this->getLastInsertID ();

                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =61.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1025;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);


                unset($commitem['ContractsItemsCommissionsItem']['id']);
                $commitem['ContractsItemsCommissionsItem']['contracts_items_id'] =$item_id;
                $commitem['ContractsItemsCommissionsItem']['modified_date'] = date('Y-m-d H:m:s');
                $commitem['ContractsItemsCommissionsItem']['percent'] =38.5;
                $commitem['ContractsItemsCommissionsItem']['employee_id'] =1479;

                $this->ContractsItemsCommissionsItem->create();
                $this->ContractsItemsCommissionsItem->save($commitem);
                return True;
            }
        }

    }
}
?>