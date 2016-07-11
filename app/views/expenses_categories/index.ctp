<div class="expensesCategories index">
    <h2><?php __('ExpensesCategories');?></h2>


    <?php echo $this->element('expense_categories/index',array('$expensesCategories'=>$expensesCategories,'displayActions'=>TRUE)); ?>

</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New ExpensesCategory', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Expenses', true), array('controller'=> 'expenses', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Expense', true), array('controller'=> 'expenses', 'action'=>'add_expense')); ?> </li>
	</ul>
</div>
