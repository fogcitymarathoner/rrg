<?php
class ContractsItemsCommissionsItem extends AppModel {

	var $name = 'ContractsItemsCommissionsItem';
	var $validate = array(
		'employee_id' => array(
		'rule' => 'notEmpty'
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContractsItems' => array(
			'className' => 'ContractsItems',
			'foreignKey' => 'contract_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

			
	function beforeSave() { 
    	$this->data['ContractsItemsCommissionsItem']['Y-m-d H:m:s'] = date('Y-m-d');
		return true;
	}
}
?>
