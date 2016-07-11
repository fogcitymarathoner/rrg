<?php //debug($commissionsPayment); ?>
<div class="commissionsPayments view">
<h2><?php  __('CommissionsPayment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employee Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['employee_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Commissions Report Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['commissions_report_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['check_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cleared'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsPayment['CommissionsPayment']['cleared']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CommissionsPayment', true), array('action' => 'edit', $commissionsPayment['CommissionsPayment']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CommissionsPayment', true), array('action' => 'delete', $commissionsPayment['CommissionsPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $commissionsPayment['CommissionsPayment']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CommissionsPayments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New CommissionsPayment', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
