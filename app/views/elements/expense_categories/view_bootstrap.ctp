<div class="row">
    <div class="col-sm-2">
        Amount
    </div>
    <div class="col-sm-2">
        Date
    </div>
    <div class="col-sm-3">
        Description
    </div>
    <div class="col-sm-3">
        Notes
    </div>
    <div class="col-sm-2">
        Actions
    </div>
</div>

    <?php

    if (!empty($expenses)):?>

            <?php
            $i = 0;
            foreach ($expenses as $expense):

            ?>

                <div class="row">
                    <div class="col-sm-2">
                        <?php echo sprintf('%8.2f',round($expense['Expense']['amount'],2)); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo date('m/d/Y',strtotime($expense['Expense']['date'])); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo $expense['Expense']['description']; ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo $expense['Expense']['notes']; ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo $html->link(__('Dup', true), array('controller'=> 'expenses_categories', 'action'=>'dup_exp',$expense['Expense']['id'])); ?>
                        <?php echo $html->link(__('View', true), array('controller'=> 'expenses_categories', 'action'=>'view_exp', $expense['Expense']['id'])); ?>
                        <?php echo $html->link(__('Edit', true), array('controller'=> 'expenses', 'action'=>'edit_exp', $expense['Expense']['id'])); ?>
                        <?php echo $html->link(__('Delete', true), array('controller'=> 'expenses_categories', 'action'=>'delete_exp', $expense['Expense']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $expense['Expense']['id'])); ?>
                    </div>
                </div>

         <?php endforeach; ?>
    <?php endif; ?>
</div>
