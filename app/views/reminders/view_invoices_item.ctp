<?php //debug($this->viewVars['invoicesItem']['InvoicesItemsCommissionsItem']);  ?>
<div class="invoicesItems view">
<h2><?php  __('InvoicesItem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoicesItem['InvoicesItem']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Invoice'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($invoicesItem['Invoice']['id'], array('controller'=> 'invoices', 'action'=>'view', $invoicesItem['Invoice']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoicesItem['InvoicesItem']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoicesItem['InvoicesItem']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoicesItem['InvoicesItem']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoicesItem['InvoicesItem']['cost']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php //echo $html->link(__('Edit InvoicesItem', true), array('action'=>'edit', $invoicesItem['InvoicesItem']['id'])); ?> </li>
		<li><?php //echo $html->link(__('Return to Invoice', true), array('controller'=> 'invoices', 'action'=>'view/'.$invoicesItem['InvoicesItem']['invoice_id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Commissions Line Items');?></h3>
	<?php if (!empty($this->viewVars['invoicesItem']['InvoicesItemsCommissionsItem'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Employee_id'); ?></th>
		<th><?php __('Percent'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->viewVars['invoicesItem']['InvoicesItemsCommissionsItem'] as $invoicesItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $invoicesItem['id'];?></td>
			<td><?php echo $invoicesItem['employee_id'];?></td>
			<td><?php echo $invoicesItem['percent'];?></td>
			<td><?php echo $invoicesItem['amount'];?></td>
			<td class="actions">
				<?php //echo $html->link(__('View', true), array('controller'=> 'invoices', 'action'=>'view', $invoicesItem['id'])); ?>
				<?php //echo $html->link(__('Edit', true), array('controller'=> 'invoices_items_commissions_items', 'action'=>'edit', $invoicesItem['id'])); ?>
				<?php //echo $html->link(__('Delete', true), array('controller'=> 'invoices_items_commissions_items', 'action'=>'delete', $invoicesItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invoicesItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
