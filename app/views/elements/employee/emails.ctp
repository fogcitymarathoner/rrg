<div class='emp-label'><a href="<?php echo $webroot?>employees/view/<?php echo $employee['Employee']['id']?>"><?php echo $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];?></a></div>
<?php
    $i = 0;
    foreach ($employee['EmployeesEmail'] as $employeesEmail):
        echo $this->element('employee/email_button', array('employeesEmail'=>$employeesEmail,'first_last'=>$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'],));
    endforeach;