<?php
class CommissionsReport extends AppModel {

	var $name = 'CommissionsReport';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'CommissionsPayment' => array(
			'className' => 'CommissionsPayment',
			'foreignKey' => 'commissions_report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'InvoicesItemsCommissionsItem' => array(
			'className' => 'InvoicesItemsCommissionsItem',
			'foreignKey' => 'commissions_report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Note' => array(
			'className' => 'Note',
			'foreignKey' => 'commissions_report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'NotesPayment' => array(
			'className' => 'NotesPayment',
			'foreignKey' => 'commissions_report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CommissionsReportsTag' => array(
			'className' => 'CommissionsReportsTag',
			'foreignKey' => 'commissions_report_id',
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

}
?>