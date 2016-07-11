<div class="employeesPayments form">
<?php echo $form->create('Employees',array('action'=>'edit_commissions_payment'));  
?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
	<?php
	
		echo $form->input('CommissionsPayment.id');
		echo $form->input('CommissionsPayment.employee_id', array('type'=>'hidden','value'=>$this->data['CommissionsPayment']['employee_id']));
		echo $form->input('CommissionsPayment.note_id', array('type'=>'hidden','value'=>$this->data['CommissionsPayment']['note_id']));
		echo $form->input('CommissionsPayment.check_number');
		echo $form->input('CommissionsPayment.description');
		echo $form->input('CommissionsPayment.date');
		echo $form->input('CommissionsPayment.amount');
		echo $form->input('CommissionsPayment.cleared');
		echo $form->input('CommissionsPayment.modified_user_id',array('name'=>'data[EmployeesMemo][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view_commissions_payments', $this->data['CommissionsPayment']['employee_id'])); ?> </li>
	</ul>
</div>