<?php
class Note extends AppModel {

	var $name = 'Note';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'CommissionsPayment' => array(
			'className' => 'CommissionsPayment',
			'foreignKey' => 'commissions_payment_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>