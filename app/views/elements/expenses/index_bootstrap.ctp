<div class="row">
    <div class="col-sm-1">
        Amount
    </div>
    <div class="col-sm-1">
        Date
    </div>
    <div class="col-sm-2">
        Category
    </div>
    <div class="col-sm-2">
        Description
    </div>
    <div class="col-sm-2">
        Notes
    </div>
    <div class="col-sm-2">
        Actions
    </div>
</div>
<?php
$i = 0;
foreach ($expenses as $expense):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<div class="row">
		<div class="col-sm-1">
			<?php echo sprintf('%8.2f',round($expense['Expense']['amount'],2)); ?>
		</div>
		<div class="col-sm-1">
			<?php echo date('m/d/Y',strtotime($expense['Expense']['date'])); ?>
		</div>
		<div class="col-sm-2">
			<?php echo $html->link($expense['ExpensesCategory']['name'], array('controller'=> 'expenses_categories', 'action'=>'view', $expense['ExpensesCategory']['id'])); ?>
		</div>
		<div class="col-sm-2">
			<?php echo $expense['Expense']['description']; ?>
		</div>
		<div class="col-sm-2">
			<?php echo $expense['Expense']['notes']; ?>
		</div>
		<div class="col-sm-2">
			<?php echo $html->link(__('Dup', true), array('controller'=> 'expenses_categories','action'=>'dup_exp', $expense['Expense']['id'])); ?>
			<?php echo $html->link(__('View', true), array('action'=>'view_expense', $expense['Expense']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit_expense', $expense['Expense']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete_expense', $expense['Expense']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $expense['Expense']['id'])); ?>
		</div>
	</div>
<?php endforeach; ?>
