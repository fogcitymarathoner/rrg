<div class="notesPayments form">
<?php echo $form->create('NotesPayment');?>
	<fieldset>
 		<legend><?php __('Add NotesPayment');?></legend>
	<?php
		echo $form->input('employee_id');
		echo $form->input('notes_report_id');
		echo $form->input('check_number');
		echo $form->input('amount');
		echo $form->input('notes');
		echo $form->input('created_date');
		echo $form->input('modified_date');
		echo $form->input('created_user_id');
		echo $form->input('modified_user_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List NotesPayments', true), array('action' => 'index'));?></li>
	</ul>
</div>
