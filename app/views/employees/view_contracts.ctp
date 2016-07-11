<?php //debug($employee); ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
		<li>
		
	<?php echo $html->link(__('New Contract For Employee', true), array('action'=>'add_contract/'.$employee['Employee']['id'])); ?>
	</li>
	</ul>
</div>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['firstname']; ?>
			<?php echo $employee['Employee']['mi']; ?>

			<?php echo $employee['Employee']['lastname']; ?>
			<?php echo $employee['Employee']['nickname']; ?>

			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Clients Contracts');?></h3>
	<?php if (!empty($employee['ClientsContract'])):?>
	<table cellpadding = "1" cellspacing = "1">
	<tr>
		<th><?php __('Client'); ?></th>
		<th><?php __('Startdate'); ?></th>
		<th><?php __('Enddate'); ?></th>
		<th><?php __('Title'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($employee['ClientsContract'] as $clientsContract):
			$class = null; //debug($clientsContract);
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $clientsContract['Client']['name'];?></td>
			<td><?php echo date('m/d/Y',strtotime($clientsContract['startdate']));?></td>
			<td><?php echo date('m/d/Y',strtotime($clientsContract['enddate']));?></td>
			<td><?php echo $clientsContract['title'];?></td>
			<td class="actions">
				<?php
				echo $html->link(__('Manage Contract', true), array('action'=>'view_contract', $clientsContract['id'])); ?>
				<?php echo $html->link(__('Edit', true), array( 'action'=>'edit_contract', $clientsContract['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_contract', $clientsContract['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $clientsContract['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
