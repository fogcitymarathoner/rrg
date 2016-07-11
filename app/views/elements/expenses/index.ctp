<table cellpadding="0" cellspacing="0" border=1>
<tr>
	<th><?php echo 'amount';?></th>
	<th><?php echo 'category_id';?></th>
	<th><?php echo 'date';?></th>
	<th><?php echo 'description';?></th>
	<th><?php echo 'notes';?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($expenses as $expense):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class; ?>>
		<td align="right">
			<?php echo sprintf('%8.2f',round($expense['Expense']['amount'],2)); ?>
		</td>
		<td>
			<?php echo $html->link($expense['Expense']['category'], array('controller'=> 'expenses_categories', 'action'=>'view', $expense['Expense']['category_id'])); ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($expense['Expense']['date'])); ?>
		</td>
		<td>
			<?php echo $expense['Expense']['description']; ?>
		</td>
		<td>
			<?php echo $expense['Expense']['notes']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Dup', true), array('controller'=> 'expenses_categories','action'=>'dup_exp', $expense['Expense']['id'])); ?>
			<?php echo $html->link(__('View', true), array('action'=>'view_expense', $expense['Expense']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit_expense', $expense['Expense']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete_expense', $expense['Expense']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $expense['Expense']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>