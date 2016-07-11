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
		
	<?php echo $html->link(__('New Letter For Employee', true), array('action'=>'add_letter/'.$employee['Employee']['id'])); ?>
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
	<h3><?php __('Related Employees Letters');?></h3>
	<?php if (!empty($employee['EmployeesLetter'])):?>
	<table cellpadding = "1" cellspacing = "1">
	<tr>
		<th><?php __('Date'); ?></th>
        <th><?php __('Title'); ?></th>
        <th><?php __('Excerpt'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($employee['EmployeesLetter'] as $letter):
			$class = null; //debug($clientsContract);
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
        <td><?php echo $letter['date'];?></td>
        <td><?php echo $letter['title'];?></td>
			<td><?php echo substr($letter['para1'],0,50);?></td>
			<td class="actions">
				<?php
				echo $html->link(__('View Letter', true), array('action'=>'view_letter', $letter['id'])); ?>
                <?php echo $html->link(__('Preview PDF', true), array( 'action'=>'preview_letter_pdf', $letter['id'])); ?>
                <?php echo $html->link(__('Edit', true), array( 'action'=>'edit_letter', $letter['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_letter', $letter['id'],$letter['employee_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $letter['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
