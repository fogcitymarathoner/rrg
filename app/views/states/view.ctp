<style>
div.cell-display {
border: solid 0 #060;  padding-left:0.5ex; padding-right:0.5ex
}



</style>
<div class="states view">
<h2><?php  __('State');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Post Ab'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['post_ab']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Capital'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['capital']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Flower'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['flower']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State No'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['state_no']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $state['State']['id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit State', true), array('action' => 'edit', $state['State']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List States', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New State', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients', true), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client', true), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Employees', true), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendors', true), array('controller' => 'vendors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor', true), array('controller' => 'vendors', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Clients');?></h3>
	<?php if (!empty($state['Client'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Street1'); ?></th>
		<th><?php __('Street2'); ?></th>
		<th><?php __('City'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Zip'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Terms'); ?></th>
		<th><?php __('Hq'); ?></th>
		<th><?php __('Ssn Crypto'); ?></th>
		<th><?php __('Registration Attempt Counter'); ?></th>
		<th><?php __('Modified Date'); ?></th>
		<th><?php __('Created Date'); ?></th>
		<th><?php __('Created User'); ?></th>
		<th><?php __('Modified User'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($state['Client'] as $client):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><div class='cell-display'><?php echo $client['id'];?></div></td>
			<td><div class='cell-display'><?php echo $client['name'];?></div></td>
			<td><div class='cell-display'><?php echo $client['street1'];?></div></td>
			<td><div class='cell-display'><?php echo $client['street2'];?></div></td>
			<td><div class='cell-display'><?php echo $client['city'];?></div></td>
			<td><div class='cell-display'><?php echo $client['state_id'];?></div></td>
			<td><div class='cell-display'><?php echo $client['zip'];?></div></td>
			<td><div class='cell-display'><?php echo $client['active'];?></div></td>
			<td><div class='cell-display'><?php echo $client['terms'];?></div></td>
			<td><div class='cell-display'><?php echo $client['hq'];?></div></td>
			<td><div class='cell-display'><?php echo $client['ssn_crypto'];?></div></td>
			<td><div class='cell-display'><?php echo $client['registration_attempt_counter'];?></div></td>
			<td><div class='cell-display'><?php echo $client['modified_date'];?></div></td>
			<td><div class='cell-display'><?php echo $client['created_date'];?></div></td>
			<td><div class='cell-display'><?php echo $client['created_user'];?></div></td>
			<td><div class='cell-display'><?php echo $client['modified_user'];?></div></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'clients', 'action' => 'view', $client['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'clients', 'action' => 'edit', $client['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'clients', 'action' => 'delete', $client['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $client['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Client', true), array('controller' => 'clients', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Employees');?></h3>
	<?php if (!empty($state['Employee'])):?>
	<table cellpadding="0" cellspacing="0" border=1>
	<tr>
		<th><?php __('Employee'); ?></th>
		<th><?php __('Startdate'); ?></th>
        <th><?php __('Enddate'); ?></th>
		<th><?php __('Street1'); ?></th>
		<th><?php __('Street2'); ?></th>
		<th><?php __('City'); ?></th>
		<th><?php __('Zip'); ?></th>
		<th><?php __('Usworkstatus'); ?></th>
		<th><?php __('Phone'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($state['Employee'] as $employee):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><div class='cell-display'><?php echo '<a href="'.$this->webroot.'employees/view/'. $employee['id'].'">'.$employee['firstname'].' '.$employee['lastname'];?></a></div></td>
			<td><div class='cell-display'><?php echo date("m/d/Y",strtotime($employee['startdate']));?></div></td>
            <td><div class='cell-display'><?php echo date("m/d/Y",strtotime($employee['enddate']));?></div></td>
			<td><div class='cell-display'><?php echo $employee['street1'];?></div></td>
			<td><div class='cell-display'><?php echo $employee['street2'];?></div></td>
			<td><div class='cell-display'><?php echo $employee['city'];?></div></td>
			<td><div class='cell-display'><?php echo $employee['zip'];?></div></td>
			<td><div class='cell-display'><?php echo $employee['usworkstatus'];?></div></td>
			<td><div class='cell-display'><?php echo $employee['phone'];?></div></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'employees', 'action' => 'view', $employee['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'employees', 'action' => 'edit', $employee['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'employees', 'action' => 'delete', $employee['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employee['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Employee', true), array('controller' => 'employees', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Vendors');?></h3>
	<?php if (!empty($state['Vendor'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Purpose'); ?></th>
		<th><?php __('Street1'); ?></th>
		<th><?php __('Street2'); ?></th>
		<th><?php __('City'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Zip'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Ssn'); ?></th>
		<th><?php __('Apfirstname'); ?></th>
		<th><?php __('Aplastname'); ?></th>
		<th><?php __('Apemail'); ?></th>
		<th><?php __('Apphonetype1'); ?></th>
		<th><?php __('Apphone1'); ?></th>
		<th><?php __('Apphonetype2'); ?></th>
		<th><?php __('Apphone2'); ?></th>
		<th><?php __('Accountnumber'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('Modified Date'); ?></th>
		<th><?php __('Created Date'); ?></th>
		<th><?php __('Created User Id'); ?></th>
		<th><?php __('Modified User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($state['Vendor'] as $vendor):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><div class='cell-display'><?php echo $vendor['id'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['name'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['purpose'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['street1'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['street2'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['city'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['state_id'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['zip'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['active'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['ssn'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['apfirstname'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['aplastname'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['apemail'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['apphonetype1'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['apphone1'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['apphonetype2'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['apphone2'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['accountnumber'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['notes'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['modified_date'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['created_date'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['created_user_id'];?></div></td>
			<td><div class='cell-display'><?php echo $vendor['modified_user_id'];?></div></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'vendors', 'action' => 'view', $vendor['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'vendors', 'action' => 'edit', $vendor['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'vendors', 'action' => 'delete', $vendor['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vendor['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Vendor', true), array('controller' => 'vendors', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
