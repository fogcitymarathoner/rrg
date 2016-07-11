<div class="expenses form">
<?php echo $form->create('Employee',array('action'=>'edit_expense'));?>
	<fieldset>
 		<legend><?php __('Edit Expense');?></legend>
	<?php
		echo $form->input('Expense.id');
		echo $form->input('Expense.amount');
		echo $form->input('Expense.category_id', array('label'=>'Category', 'options'=>$expensesCategories), null, array(), '-- Select an Expense Category --');

		echo $form->input('Expense.date');
		echo $form->input('Expense.description',array('size'=>100));
		echo $form->input('Expense.notes',array('size'=>100));
        echo $form->input('Expense.employee_id',array('label'=>'Employee', 'options'=>$employees, 'default'=>$current_employee), null, array(), '-- Select an Employee --');
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Expense.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Expense.id'))); ?></li>
		<li><?php echo $html->link(__('List Expenses', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Expenses Categories', true), array('controller'=> 'expenses_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Expenses Category', true), array('controller'=> 'expenses_categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
