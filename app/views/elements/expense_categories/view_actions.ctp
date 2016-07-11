<div class="actions">
    <ul>
        <li><?php echo $html->link(__('List ExpensesCategories', true), array('action'=>'index')); ?> </li>
        <li><?php echo $html->link(__('New Expense', true), array('controller'=> 'expenses', 'action'=>'add_expense'));?> </li>
        <li><?php echo $html->link(__('List Expenses', true), array('controller'=> 'expenses', 'action'=>'index')); ?> </li>    </ul>
</div>