<div class="employeesMemos form">
<?php echo $form->create('Employees',array('action'=>'add_notes_payment'));?>
	<fieldset>
 		<legend><?php __('Add Notes Payment');?></legend> 
	<?php 
		echo $form->input('NotesPayment.check_number');
		echo $form->input('NotesPayment.date');
		echo $form->input('NotesPayment.notes');
		echo $form->input('NotesPayment.amount');
		echo $form->input('NotesPayment.employee_id',array('type'=>'hidden','value'=>$this->data['NotesPayment']['employee_id']));
		echo $form->input('NotesPayment.modified_user_id',array('name'=>'data[Note][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('NotesPayment.created_user_id',array('name'=>'data[Note][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view_notes_payments', $this->data['NotesPayment']['employee_id'])); ?> </li>
	</ul>
</div>
