<div class="expenses form">
<?php echo $form->create('Expense', array('action'=>'/index'));?>
	<fieldset>
 		<legend><?php __('Search Expenses');?></legend>
	<?php
		echo $form->input('amount');
		echo $form->input('category_id',
		array( 'type' => 'select',
                'empty' => '-- Select an expense category --',
                'multiple' => 'checkbox',
                'options' => $expensesCategories,
                'label' => 'Category'));

		echo $form->input('description');
		echo $form->input('notes');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
