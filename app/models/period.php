<?php
class Period extends AppModel {

	var $name = 'Period';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'ClientsContract' => array('className' => 'ClientsContract',
								'foreignKey' => 'period_id',
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