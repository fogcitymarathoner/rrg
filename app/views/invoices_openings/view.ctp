<div class="invoicesOpenings view">
<h2><?php  __('Invoices Opening');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoicesOpening['InvoicesOpening']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employee'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($invoicesOpening['Employee']['id'], array('controller' => 'employees', 'action' => 'view', $invoicesOpening['Employee']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Invoice'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($invoicesOpening['Invoice']['id'], array('controller' => 'invoices', 'action' => 'view', $invoicesOpening['Invoice']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invoices Opening', true), array('action' => 'edit', $invoicesOpening['InvoicesOpening']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Invoices Opening', true), array('action' => 'delete', $invoicesOpening['InvoicesOpening']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invoicesOpening['InvoicesOpening']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices Openings', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoices Opening', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Employees', true), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices', true), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice', true), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
