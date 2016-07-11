<div class="states form">
<?php echo $this->Form->create('State');?>
	<fieldset>
		<legend><?php __('Edit State'); ?></legend>
	<?php
		echo $this->Form->input('post_ab');
		echo $this->Form->input('capital');
		echo $this->Form->input('date');
		echo $this->Form->input('flower');
		echo $this->Form->input('name');
		echo $this->Form->input('state_no');
		echo $this->Form->input('id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('State.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('State.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List States', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Clients', true), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client', true), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Employees', true), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendors', true), array('controller' => 'vendors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor', true), array('controller' => 'vendors', 'action' => 'add')); ?> </li>
	</ul>
</div>