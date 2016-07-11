<div class="commissionsPayments form">
<?php echo $form->create('CommissionsPayment');?>
	<fieldset>
 		<legend><?php __('Add CommissionsPayment');?></legend>
	<?php
		echo $form->input('employee_id');
		echo $form->input('check_number');
		echo $form->input('description');
		echo $form->input('date');
		echo $form->input('amount');
		echo $form->input('cleared');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CommissionsPayments', true), array('action' => 'index'));?></li>
	</ul>
</div>
