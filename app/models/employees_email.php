<?php
class EmployeesEmail extends AppModel {

	var $name = 'EmployeesEmail';
	var $validate = array(
		'employee_id' => array('notempty'),
		'email' => array('notempty')
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>