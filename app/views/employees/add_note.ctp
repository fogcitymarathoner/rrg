<div class="employeesMemos form">
<?php echo $form->create('Employees',array('action'=>'add_note'));?>
	<fieldset>
 		<legend><?php __('Add Note');?></legend>
	<?php
		echo $form->input('Note.date');
		echo $form->input('Note.amount');
        echo $form->input('Note.notes');
        echo $form->input('Note.opening');
		echo $form->input('Note.employee_id',array('type'=>'hidden','value'=>$this->data['Note']['employee_id']));
		echo $form->input('modified_user_id',array('name'=>'data[Note][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('name'=>'data[Note][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id'])); ?> </li>
	</ul>
</div>
