<div class="expenses index">
    <h2><?php echo $this->element('expense_categories/view_header',array('expensesCategory'=>$expensesCategory))?></h2>

    <div class="actions">

        <?php echo $this->element('expense_categories/view_actions',array('expensesCategory'=>$expensesCategory))?>
    </div>

    <div class="container-fluid">
        <div class="row">
                <div class="col-sm-2">
                    <div class="cliente">
                        <?php echo $this->element('expense_categories/index_bootstrap',array('expensesCategories'=>$expensesCategories,'displayActions'=>TRUE)); ?>
                    </div>

                </div>
                <div class="col-sm-10">
                    <div class="cliente">
                        <?php echo $this->element('expense_categories/view_bootstrap',array('expenses'=>$expenses))?>
                    </div>
                </div>
        </div>
    </div>


</div>