<div class="employeesPayments form">
<?php echo $form->create('Invoices',array('action'=>'edit_employee_payment')); ?>
	<fieldset>
 		<legend><?php __('Edit Employees Payment');?></legend>
	<?php
		echo $form->input('EmployeesPayment.id');
		echo $form->input('EmployeesPayment.employee_id', array('type'=>'hidden','value'=>$this->data['Employee']['id']));
		echo $form->input('EmployeesPayment.invoice_id', array('type'=>'hidden','value'=>$this->data['Invoice']['id']));
		echo $form->input('EmployeesPayment.date');
		echo $form->input('EmployeesPayment.ref');
		echo $form->input('EmployeesPayment.amount');
		echo $form->input('EmployeesPayment.notes', array('size'=>120));
		echo $form->input('EmployeesPayment.modified_user_id',array('name'=>'data[EmployeesMemo][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Invoice', true), array('action'=>'view', $this->data['Invoice']['id'])); ?> </li>
	</ul>
</div>