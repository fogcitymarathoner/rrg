<?php
class ExpensesCategory extends AppModel {

	var $name = 'ExpensesCategory';
	var $hasMany = array(
			'Expense' => array('className' => 'Expense',
								'foreignKey' => 'category_id',
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

}
?>