<div class="employeesPayments form">
<?php echo $form->create('Employees',array('action'=>'edit_note'));  
?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
	<?php
	
		echo $form->input('Note.id');
		echo $form->input('Note.employee_id', array('type'=>'hidden','value'=>$this->data['CommissionsPayment']['employee_id']));
		echo $form->input('Note.commissions_payment_id', array('type'=>'hidden','value'=>$this->data['CommissionsPayment']['note_id']));

		echo $form->input('Note.date');
		echo $form->input('Note.amount');
		echo $form->input('Note.notes');
		echo $form->input('Note.opening');
		echo $form->input('Note.modified_user_id',array('name'=>'data[EmployeesMemo][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id'])); ?> </li>
	</ul>
</div>
        <?php // debug($this->data); ?>