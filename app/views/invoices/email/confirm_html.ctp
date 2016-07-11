<?php //debug($this->viewVars); 
exit;
?>
<div class="invoices view">
<h2><?php  __('Invoice');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Clients Contract'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($invoice['ClientsContract']['title'], array('controller'=> 'clients_contracts', 'action'=>'view', $invoice['ClientsContract']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Po'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['po']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employerexpenserate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['employerexpenserate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Terms'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['terms']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Timecard'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['timecard']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Posted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['posted']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cleared'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['cleared']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Voided'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['voided']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Invoice Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['message']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period Start'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['period_start']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period End'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoice['Invoice']['period_end']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo round($invoice['Invoice']['amount'],2); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Invoice', true), array('action'=>'edit', $invoice['Invoice']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Invoices', true), array('action'=>'index_s')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Line Items');?></h3>
	<?php if (!empty($invoice['InvoicesItem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Invoice Id'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($invoice['InvoicesItem'] as $invoicesItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $invoicesItem['id'];?></td>
			<td><?php echo $invoicesItem['invoice_id'];?></td>
			<td><?php echo $invoicesItem['description'];?></td>
			<td><?php echo $invoicesItem['amount'];?></td>
			<td><?php echo $invoicesItem['quantity'];?></td>
			<td><?php echo $invoicesItem['cost'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'invoices_items', 'action'=>'view', $invoicesItem['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'invoices_items', 'action'=>'edit', $invoicesItem['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'invoices_items', 'action'=>'delete', $invoicesItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invoicesItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Invoices Item', true), array('controller'=> 'invoices_items', 'action'=>'add','invoice_id'=>$invoice['Invoice']['id']));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Payments');?></h3>
	<?php if (!empty($invoice['InvoicesPayment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Invoice Id'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Reference'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($invoice['InvoicesPayment'] as $invoicesPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $invoicesPayment['id'];?></td>
			<td><?php echo $invoicesPayment['invoice_id'];?></td>
			<td><?php echo $invoicesPayment['date'];?></td>
			<td><?php echo $invoicesPayment['reference'];?></td>
			<td><?php echo $invoicesPayment['amount'];?></td>
			<td><?php echo $invoicesPayment['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'invoices_payments', 'action'=>'view', $invoicesPayment['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'invoices_payments', 'action'=>'edit', $invoicesPayment['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'invoices_payments', 'action'=>'delete', $invoicesPayment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invoicesPayment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Invoices Payment', true), array('controller'=> 'invoices_payments', 'action'=>'add','invoice_id'=>$invoice['Invoice']['id']));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Employees Payments');?></h3>
	<?php if (!empty($invoice['EmployeesPayment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Invoice Id'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Reference'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($invoice['EmployeesPayment'] as $employeesPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $employeesPayment['id'];?></td>
			<td><?php echo $employeesPayment['invoice_id'];?></td>
			<td><?php echo $employeesPayment['date'];?></td>
			<td><?php echo $employeesPayment['ref'];?></td>
			<td><?php echo $employeesPayment['amount'];?></td>
			<td><?php echo $employeesPayment['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'employees_payments', 'action'=>'view', $employeesPayment['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'employees_payments', 'action'=>'edit', $employeesPayment['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'employees_payments', 'action'=>'delete', $employeesPayment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesPayment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Employees Payment', true), array('controller'=> 'employees_payments', 'action'=>'add','invoice_id'=>$invoice['Invoice']['id']));?> </li>
		</ul>
	</div>
</div>
