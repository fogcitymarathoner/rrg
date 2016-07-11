<div class="employeesPayments form">
<?php echo $this->Form->create('EmployeesPayment');?>
	<fieldset>
		<legend><?php __('Edit Employees Payment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('employee_id');
		echo $this->Form->input('invoice_id');
		echo $this->Form->input('payroll_id');
		echo $this->Form->input('date');
		echo $this->Form->input('ref');
		echo $this->Form->input('amount');
		echo $this->Form->input('notes');
		echo $this->Form->input('ordering');
		echo $this->Form->input('securitytoken');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('EmployeesPayment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('EmployeesPayment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Employees Payments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Employees', true), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payrolls', true), array('controller' => 'payrolls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payroll', true), array('controller' => 'payrolls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices', true), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice', true), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>