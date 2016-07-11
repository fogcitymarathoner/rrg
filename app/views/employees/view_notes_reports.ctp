<?php //debug($employee); ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
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
	<h3><?php __('Related Employees Commissions Reports');?></h3>
	<?php if (!empty($employee['CommissionsReportsTag'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1 >
	<tr>
		<th><?php __('Period Id'); ?></th>
		<th><?php __('Period'); ?></th>
		<th><?php __('Commissions Balance'); ?></th>
		<th><?php __('Notes Balance'); ?></th>
		<th><?php __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		$total = 0;
		foreach ($employee['CommissionsReportsTag'] as $employeesCommTag):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $employeesCommTag['id'];  ?></td>
			<td><?php echo $employeesCommTag['period'];?></td>

			<td align="right"><?php echo sprintf('%8.2f',round($employeesCommTag['comm_balance'],2));  ?></td>
			<td align="right"><?php echo sprintf('%8.2f',round($employeesCommTag['note_balance'],2));  ?></td>
			<td align=right >
				<?php echo $html->link(__('View', true), array('action' => 'view_notes_tagged_report', $employeesCommTag['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>