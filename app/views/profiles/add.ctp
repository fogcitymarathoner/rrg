<div class="profiles form">
<?php echo $this->Form->create('Profile');?>
	<fieldset>
		<legend><?php __('Add Profile'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		//echo $this->Form->input('employee_id');

            echo $form->input('employee_id',array('label'=>'Employee', 'options'=>$employees), null, array(), '-- Select an Employee --');
		echo $this->Form->input('sphene_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Profiles', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Employees', true), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add')); ?> </li>
	</ul>
</div>