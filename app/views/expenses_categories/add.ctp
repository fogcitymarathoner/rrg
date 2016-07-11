<div class="expensesCategories form">
<?php echo $form->create('ExpensesCategory');?>
	<fieldset>
 		<legend><?php __('Add ExpensesCategory');?></legend>
	<?php
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ExpensesCategories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Expenses', true), array('controller'=> 'expenses', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Expense', true), array('controller'=> 'expenses', 'action'=>'add')); ?> </li>
	</ul>
</div>
