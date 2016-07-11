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
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Employees Notes Payments');?></h3>
	<?php if (!empty($notes_payments)):?>
	<table cellpadding = "3" cellspacing = "3" border=1 >
	<tr>
		<th><?php __('comperiodid'); ?></th>
		<th><?php __('CheckNumber'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($notes_payments as $employeesPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			} //debug($employeesPayment);
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $employeesPayment['NotesPayment']['commissions_report_id'];?></td>
			<td><?php echo $employeesPayment['NotesPayment']['check_number'];?></td>
			<td><?php echo date('m/d/Y',strtotime($employeesPayment['NotesPayment']['date']));?></td>
			
			<td align=right ><?php echo number_format  ($employeesPayment['NotesPayment']['amount'],2);?></td>
			<td><?php echo $employeesPayment['NotesPayment']['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_notes_payment', $employeesPayment['NotesPayment']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_notes_payment', $employeesPayment['NotesPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesPayment['NotesPayment']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Notes Payments', true), array('action'=>'add_notes_payment/'.$employee['Employee']['id']));?> </li>
		</ul>
	</div>