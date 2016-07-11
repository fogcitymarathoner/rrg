<?php //debug($employee); ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('New Commissions Payment', true), array('action'=>'add_commissions_payment/'.$employee['Employee']['id']));?> </li>
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
		<li><?php echo $html->link(__('New Commissions Payment', true), array('action'=>'add_commissions_payment/'.$employee['Employee']['id']));?> </li>
	</ul>
</div>

<div class="related">
	<h3><?php __('Related Employees Commissions Payments');?></h3>
	<?php if (!empty($payments)):?>
	<table cellpadding = "3" cellspacing = "3" border=1 >
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('CheckNumber'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($payments as $employeesPayment): //debug($employeesPayment);
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?><?php //debug($employeesPayment);//exit;?>
		<tr<?php echo $class;?>>
			<td><?php echo $employeesPayment['CommissionsPayment']['id'];?></td>
			<td><?php echo $employeesPayment['CommissionsPayment']['check_number'];?></td>
			<td><?php echo date('m/d/Y',strtotime($employeesPayment['CommissionsPayment']['date']));?></td>
			<td><?php echo $employeesPayment['CommissionsPayment']['description'];?></td>
		
			<td align=right ><?php echo number_format  ($employeesPayment['CommissionsPayment']['amount'],2);?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_commissions_payment', $employeesPayment['CommissionsPayment']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_commissions_payment', $employeesPayment['CommissionsPayment']['id'], $employeesPayment['CommissionsPayment']['employee_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesPayment['CommissionsPayment']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Commissions Payment', true), array('action'=>'add_commissions_payment/'.$employee['Employee']['id']));?> </li>
	</ul>
</div>
