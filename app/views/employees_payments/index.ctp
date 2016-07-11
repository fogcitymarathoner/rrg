<div class="employeesPayments index">
	<h2><?php __('Employees Payments');?></h2>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
			<th><?php echo $this->Paginator->sort('date');?></th>
			<th><?php echo $this->Paginator->sort('ref');?></th>
			<th><?php echo 'Employee';?></th>
			<th><?php echo $this->Paginator->sort('amount');?></th>
			<th><?php echo $this->Paginator->sort('notes');?></th>
			<th><?php echo $this->Paginator->sort('invoice_id');?></th>
			<th><?php echo $this->Paginator->sort('payroll_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($employeesPayments as $employeesPayment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>

		<td><?php echo
		date('m/d/Y',strtotime($employeesPayment['EmployeesPayment']['date']));?>
		&nbsp;</td>
		<td><?php echo $employeesPayment['EmployeesPayment']['ref']; ?>&nbsp;</td>

		<td>
			<?php echo $this->Html->link($employeesPayment['Employee']['firstname'].' '.$employeesPayment['Employee']['lastname'], array('controller' => 'employees', 'action' => 'view_payments', $employeesPayment['Employee']['id'])); ?>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($employeesPayment['EmployeesPayment']['amount'],2)); ?>
		</td>

		<td><?php echo $employeesPayment['EmployeesPayment']['notes']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($employeesPayment['Invoice']['id'], array('controller' => 'invoices', 'action' => 'view', $employeesPayment['Invoice']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($employeesPayment['Payroll']['name'], array('controller' => 'payrolls', 'action' => 'view', $employeesPayment['Payroll']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $employeesPayment['EmployeesPayment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $employeesPayment['EmployeesPayment']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $employeesPayment['EmployeesPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesPayment['EmployeesPayment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Employees Payment', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Employees', true), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payrolls', true), array('controller' => 'payrolls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payroll', true), array('controller' => 'payrolls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices', true), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice', true), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>