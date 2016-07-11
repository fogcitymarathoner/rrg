<?php
class User extends AppModel {

	var $name = 'User';
	var $displayField='username';
	var $hasMany = array(
		);
    var $hasOne = array(
        'Profile' => array(
        'className' => 'Profile',
        'dependent' => true
        )
    );
	var $validate = array(
		'id' => array('rule' => 'blank',
					  'on' => 'create'),
		'username' => array('rule' => 'alphanumeric',
							'required' => true,
							'message' => 'Please enter a username'),
		'firstname' => array('rule' => 'alphanumeric',
							'required' => true,
							'message' => 'Please enter a first name'),
		'lastname' => array('rule' => 'alphanumeric',
							'required' => true,
							'message' => 'Please enter a last name'),
		'password' => array('rule' => array('confirmPassword', 'password'),
							'message' => 'Passwords do not match'),
		'password_confirm' => array('rule' => 'alphanumeric',
									'required' => true)
	);
	function confirmPassword($data) {
		$valid = false; 
		if ($data['password'] == Security::hash(Configure::read('Security.salt') . $this->data['User']['password_confirm'])) {
			$valid = true;
		}
		return $valid;
	}
		
		

}
?>
