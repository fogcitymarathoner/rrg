<div class="commissionsPayments index">
<h2><?php __('CommissionsPayments');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="1" cellspacing="1" border=1>
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('employee_id');?></th>
	<th><?php echo $paginator->sort('commissions_report_id');?></th>
	<th><?php echo $paginator->sort('number');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('cleared');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($commissionsPayments as $commissionsPayment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $commissionsPayment['CommissionsPayment']['id']; ?>
		</td>
		<td>
			<?php echo $commissionsPayment['CommissionsPayment']['employee_id']; ?>
		</td>
		<td>
			<?php echo $commissionsPayment['CommissionsPayment']['commissions_report_id']; ?>
		</td>
		<td>
			<?php echo $commissionsPayment['CommissionsPayment']['check_number']; ?>
		</td>
		<td>
			<?php echo $commissionsPayment['CommissionsPayment']['description']; ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($commissionsPayment['CommissionsPayment']['date'])); ?>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($commissionsPayment['CommissionsPayment']['amount'],2)); ?>
		</td>
		<td>
			<?php echo $commissionsPayment['CommissionsPayment']['cleared']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $commissionsPayment['CommissionsPayment']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $commissionsPayment['CommissionsPayment']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $commissionsPayment['CommissionsPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $commissionsPayment['CommissionsPayment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New CommissionsPayment', true), array('action' => 'add')); ?></li>
	</ul>
</div>