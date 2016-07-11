<div class="employeesMemos form">
<?php echo $form->create('Employees',array('action'=>'add_commissions_payment'));?>
	<fieldset>
 		<legend><?php __('Add Commissions Payment');?></legend> 
	<?php //CommissionsPayment
		echo $form->input('CommissionsPayment.check_number');
		echo $form->input('CommissionsPayment.date');
		echo $form->input('CommissionsPayment.description');
		echo $form->input('CommissionsPayment.amount');
		echo $form->input('CommissionsPayment.employee_id',array('type'=>'hidden','value'=>$this->data['CommissionsPayment']['employee_id']));
		echo $form->input('CommissionsPayment.modified_user_id',array('name'=>'data[CommissionsPayment][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('CommissionsPayment.created_user_id',array('name'=>'data[CommissionsPayment][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view_commissions_payments', $this->data['CommissionsPayment']['employee_id'])); ?> </li>
	</ul>
</div>
