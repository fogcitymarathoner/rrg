<?php
class EmployeesPayment extends AppModel {

	var $name = 'EmployeesPayment';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Employee' => array('className' => 'Employee',
								'foreignKey' => 'employee_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Payroll' => array('className' => 'Payroll',
								'foreignKey' => 'payroll_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Invoice' => array('className' => 'Invoice',
								'foreignKey' => 'invoice_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>