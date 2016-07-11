<?php
//debug($this->data);
?>
<div class="invoices form">
<?php echo $form->create('Invoice');?>
	<fieldset>
 		<legend><?php __('Add Invoice');?></legend>
	<?php
		echo $form->input('contract_id',
				array('type'=>'hidden'));
		echo $form->input('date');
		echo $form->input('po');
		echo $form->input('employerexpenserate',
				array('type'=>'hidden'));
		echo $form->input('terms');
		echo $form->input('timecard');
		echo $form->input('posted');
		echo $form->input('cleared');
		echo $form->input('voided');
		echo $form->input('notes',array('AUTOCOMPLETE'=>'OFF','size'=>100));
		echo $form->input('message',
				array('empty'=>'Thank you for your business'));
		echo $form->input('period_start');
		echo $form->input('period_end');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Invoices', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Clients Contracts', true), array('controller'=> 'clients_contracts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Clients Contract', true), array('controller'=> 'clients_contracts', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Invoices Items', true), array('controller'=> 'invoices_items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Invoices Item', true), array('controller'=> 'invoices_items', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Invoices Payments', true), array('controller'=> 'invoices_payments', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Invoices Payment', true), array('controller'=> 'invoices_payments', 'action'=>'add')); ?> </li>
	</ul>
</div>
