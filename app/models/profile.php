<?php
class Profile extends AppModel {
	var $name = 'Profile';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    function make_employee_profile($employee)
    {
        $profile = array();
        $profile['Profile']['employee_id'] = $employee['Employee']['id'];
        $user = array();
        $user['User']['username'] = $employee['Employee']['username'];
        $user['User']['firstname'] = $employee['Employee']['firstname'];
        $user['User']['lastname'] = $employee['Employee']['lastname'];
        $this->User->create();
        if($this->User->save($user))
        {
            $profile['Profile']['user_id'] = $this->User->getLastInsertID();
            $this->create();
            $this->save($profile);
            return array(0,'user saved');
        } else {
            return array(1,'user not saved');
        }
    }
    function fix_profiles()
    {
        $emps = $this->Employee->find('all',null);
        foreach ($emps as $emp)
        {
            //debug($emp);exit;
            if ($emp['Profile']['id']== null)
            {
                //debug($emp['Employee']);
                print $emp['Employee']['username'].' '.$emp['Employee']['firstname'].' '.$emp['Employee']['lastname'].' '.$emp['Employee']['id'].'\n';
            }
        }
    }
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $size = strlen( $chars );
        $str = '';
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }
    function fix_employee_profile2($employee)
    {
        //debug($employee);
        if(in_array($employee['Employee']['id'], array(1477,1609)))
            ;
            return;
        //exit;
        $profile = array();
        $profile['Profile']['employee_id'] = $employee['Employee']['id'];
        $user = array();
        //$user['User']['firstname'] = preg_replace (' ','-',$employee['Employee']['firstname']);
        App::import('Component', 'RrgString');
        $rrgS = new RrgStringComponent();

        if($employee['Employee']['firstname']!=Null)
        {
            $user['User']['firstname'] = str_replace (' ','',$employee['Employee']['firstname']);
        } else {
            $user['User']['firstname'] = $rrgS->rand_string(10);
        }
        if($employee['Employee']['lastname'])
        {
            $user['User']['lastname'] = str_replace (' ','',$employee['Employee']['lastname']);
        } else {
            $user['User']['lastname'] = $rrgS->rand_string(10);
        }
        $user['User']['username'] = $rrgS>rand_string(1).$user['User']['lastname'];
        $user['User']['active'] = $employee['Employee']['active'];
        $user['User']['password'] = $rrgS->rand_string(10);
        $user['User']['password_confirm'] = $user['User']['password'];
        $this->data['User']['password_confirm'] = $user['User']['password'];
        $this->data['User']['password'] = $user['User']['password'];
        $user['User']['group'] = 3;
        //debug($user);
        if($this->User->save($user))
        {
            $profile['Profile']['user_id'] = $this->User->getLastInsertID();
            //debug($profile);
            $this->create();
            if($this->save($profile))
            {
                echo 'profile saved';
            } else
            {
                echo 'profile not saved';
            }
        } else
        {
            echo 'user not saved';
            print_r($user); exit;
        }
    }
}
