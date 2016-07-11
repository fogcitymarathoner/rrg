<div class="expensesCategories form">
<?php echo $form->create('ExpensesCategory');?>
	<fieldset>
 		<legend><?php __('Edit ExpensesCategory');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ExpensesCategory.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ExpensesCategory.id'))); ?></li>
		<li><?php echo $html->link(__('List ExpensesCategories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Expenses', true), array('controller'=> 'expenses', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Expense', true), array('controller'=> 'expenses', 'action'=>'add')); ?> </li>
	</ul>
</div>
