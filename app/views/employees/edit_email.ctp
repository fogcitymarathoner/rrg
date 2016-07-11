<div class="employeesEmails form">
<?php echo $form->create('Employees',array('action'=>'edit_email')); //debug($this->data);?>
	<fieldset>
 		<legend><?php __('Edit Employees Email');?></legend>
	<?php
		echo $form->input('EmployeesEmail.id' , array('type' => 'hidden'));
		echo $form->input('EmployeesEmail.employee_id' , array('type' => 'hidden'));
		echo $form->input('EmployeesEmail.email');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view', $this->data['EmployeesEmail']['employee_id'])); ?> </li>
	</ul>
</div>