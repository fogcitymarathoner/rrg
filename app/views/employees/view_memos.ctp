<?php //debug($employee); ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employee', true), array('action'=>'index'));?></li>
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

<style>
div.related table tbody tr td {padding-left: 10px}
div.related table tbody tr td:first-child {width: 80px}
</style>
<div class="related">
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Employee Memo', true), array('action'=>'add_memo',$employee['Employee']['id']));?> </li>
		</ul>
	</div>

	<h3><?php __('Related Employees Memos');?></h3>
	<?php if (!empty($employee['EmployeesMemo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($employee['EmployeesMemo'] as $employeesMemo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $employeesMemo['date'];?></td>
			<td><?php echo $employeesMemo['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_memo', $employeesMemo['id'])); ?>
				<?php echo $html->link(__('Delete', true), array( 'action'=>'delete_memo/'.$employeesMemo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesMemo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
