<div class="expenses view">
<h2><?php  __('Expense');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $expense['Expense']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $expense['Expense']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Expenses Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($expense['ExpensesCategory']['name'], array('controller'=> 'expenses_categories', 'action'=>'view', $expense['ExpensesCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $expense['Expense']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $expense['Expense']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $expense['Expense']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employee'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $expense['Employee']['firstname'].' '.$expense['Employee']['lastname']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Expense', true), array('controller'=>'expenses','action'=>'edit_exp', $expense['Expense']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Expense', true), array('action'=>'delete_exp', $expense['Expense']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $expense['Expense']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Expenses', true), array('action'=>'view/'.$expense['Expense']['category_id'])); ?> </li>
		<li><?php echo $html->link(__('List Expenses Categories', true), array('controller'=> 'expenses_categories', 'action'=>'index')); ?> </li>
	</ul>
</div>
