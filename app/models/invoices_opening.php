<?php
// phoney invoices for sales staff opening commissions balances from other systems
//
class InvoicesOpening extends AppModel {
	var $name = 'InvoicesOpening';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'invoice_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}