<?php
class ClientsSearch extends AppModel {

	var $name = 'ClientsSearch';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Client' => array('className' => 'Client',
								'foreignKey' => 'client_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
	);

	var $hasAndBelongsToMany = array(
			'Resume' => array('className' => 'Resume',
						'joinTable' => 'searches_resumes',
						'foreignKey' => 'search_id',
						'associationForeignKey' => 'resume_id',
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
    	$this->data['ClientsSearch']['modified_date'] = date('Y-m-d H:m:s');
    	$this->data['Resume'] = $this->data['ClientsSearch']['Resume'];
    	//debug($this->data);exit;
		return true;
	}

}
?>