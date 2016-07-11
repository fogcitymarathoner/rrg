<div class="employeesEmails form">
<?php echo $form->create('Employees',array('action'=>'add_email'));?>
	<fieldset>
 		<legend><?php __('Add Employees Email');?></legend>
	<?php
		echo $form->input( 'EmployeesEmail.employee_id', array( 'value' => $employee['Employee']['id'] , 'type' => 'hidden') ); 
		echo $form->input('EmployeesEmail.email',array('size'=>60));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view', $employee['Employee']['id'])); ?> </li>
	</ul>
</div>