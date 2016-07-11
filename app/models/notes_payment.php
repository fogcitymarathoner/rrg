<?php
class NotesPayment extends AppModel {

	var $name = 'NotesPayment';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
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
//commissions_report_id
//notes_reports_tag_id
}
?>