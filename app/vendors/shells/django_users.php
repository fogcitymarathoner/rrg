<?php
// fills in employee slug and username;
// user name should email address
class DjangoUsersShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }
	function multiname($employee)
	{debug($employee);
    	App::import('Model', 'Employee');
    	$employeeModel = new Employee;
		$i = 1;
		$samenameemps = $employeeModel->find('all',array('conditions'=>array('firstname'=>$employee['Employee']['firstname'],'lastname'=>$employee['Employee']['lastname'])));
		foreach ($samenameemps as $emp)
		{
			//debug($emp);
			$writeemp['Employee']['id'] = $emp['Employee']['id'];
			if($i ==1 && $emp['Employee']['slug']==null)
			{
				$writeemp['Employee']['slug'] = strtolower (str_replace (' ','',$employee['Employee']['firstname'].'-'.$employee['Employee']['lastname'].'-'.$employee['Employee']['id']));

				$writeemp['Employee']['username'] = strtolower (str_replace (' ','',substr ($employee['Employee']['firstname'],0,1).$employee['Employee']['lastname']));
				//debug($writeemp);
				$employeeModel->save($writeemp);
			} else {
				if($emp['Employee']['slug']==null)
				{
					$j = $i - 1;
					$writeemp['Employee']['slug'] = strtolower (str_replace (' ','',$employee['Employee']['firstname'].'-'.$employee['Employee']['lastname'].'-'.$j.'-'.$employee['Employee']['id']));		
					$writeemp['Employee']['username'] = strtolower (str_replace (' ','',substr ($employee['Employee']['firstname'],0,1).$employee['Employee']['lastname'].$j));
    				$employeeModel->save($writeemp);
				}
			}
			$i++;
			
		}		
	}
    function main() {
    	
    	App::import('Controller', 'App');
    	App::import('Model', 'Employee');
    	$employeeModel = new Employee;
    	$employees = $employeeModel->find('all');
    	foreach($employees as $employee):
            /*debug($employee);
            debug($employee['EmployeesEmail'][0]['email']);exit;
            if ($employee['Employee']['slug']==null)*/
            if (1==1)
    		{
	    		$writeemp['Employee']['id'] = $employee['Employee']['id'];
				$count = $employeeModel->find('count',array('conditions'=>array('firstname'=>$employee['Employee']['firstname'],'lastname'=>$employee['Employee']['lastname'])));
				if ($count == 1)
				{   			
					$writeemp['Employee']['slug'] = strtolower (str_replace (' ','',$employee['Employee']['firstname'].'-'.$employee['Employee']['lastname'].'-'.$employee['Employee']['id']));


				} else {
					$this->multiname($employee);
				}
                if (isset($employee['EmployeesEmail'][0]['email']) && $employee['EmployeesEmail'][0]['email'] != null)
                {
                    $username = $employee['EmployeesEmail'][0]['email'];
                    $username_count = $employeeModel->find('count',array('conditions'=>array('username like "'.$username.'%"','Employee.id !='.$employee['Employee']['id'])));
                    if($username_count == 0)
                    {
                        $writeemp['Employee']['username'] = $username;
                    }
                    else
                    {
                        $writeemp['Employee']['username'] = $username.(string)($username_count);
                    }
                }
    			$employeeModel->save($writeemp);
    		}	
			//debug($writeemp);
    	endforeach;
    	exit;
    	// Generate Reminders
    	
    	$reminderModel = new Reminder;
    	$reminderModel->generate();
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
