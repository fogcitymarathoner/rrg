<?php
class State extends AppModel {

	var $name = 'State';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Client' => array('className' => 'Client',
								'foreignKey' => 'state_id',
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
			'Employee' => array('className' => 'Employee',
								'foreignKey' => 'state_id',
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
			'Vendor' => array('className' => 'Vendor',
								'foreignKey' => 'state_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>