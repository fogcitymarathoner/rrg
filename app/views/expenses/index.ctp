<div class="expenses index">
    <h2><?php __('Expenses');?></h2>
    <p>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Annual Report', true), array('controller'=> 'expenses', 'action'=>'select_year')); ?> </li>

            <li><?php echo $html->link(__('Year Category Report', true), array('controller'=> 'expenses', 'action'=>'select_category_year')); ?> </li>
            <li><?php echo $html->link(__('New Expense', true), array('controller'=> 'expenses', 'action'=>'add_expense')); ?> </li>
            <li>&nbsp;</li>

            <li><?php echo $html->link(__('Search Expenses', true), array('controller'=> 'expenses', 'action'=>'search')); ?> </li>
            <li><?php echo $html->link(__('New Expense', true), array('action'=>'add_expense')); ?></li>
            <li><?php echo $html->link(__('List Expenses Categories', true), array('controller'=> 'expenses_categories', 'action'=>'index')); ?> </li>
            <li><?php echo $html->link(__('New Expenses Category', true), array('controller'=> 'expenses_categories', 'action'=>'add')); ?> </li>

        </ul>
    </div>

    <div class="container-fluid">
        <div class="row">
                <div class="col-sm-2">
                    <div class="cliente">
                        <?php echo $this->element('expense_categories/index_bootstrap',array('expensesCategories'=>$expenses_categories,'displayActions'=>TRUE)); ?>
                    </div>

                </div>
                <div class="col-sm-10">
                    <div class="cliente">
                        <?php echo $this->element('expenses/index_bootstrap', array('expenses'=>$expenses,'webroot'=>$this->webroot,));?>
                    </div>
                </div>
        </div>
    </div>


</div>