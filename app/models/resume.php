<?php
class Resume extends AppModel {

	var $name = 'Resume';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
	);

	var $hasAndBelongsToMany = array(
			'ClientsSearch' => array('className' => 'ClientsSearch',
						'joinTable' => 'searches_resumes',
						'foreignKey' => 'resume_id',
						'associationForeignKey' => 'search_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

	function beforeSave() {
    	$this->data['Resume']['modified_date'] = date('Y-m-d H:m:s');
		return true;
	}		
}
?>