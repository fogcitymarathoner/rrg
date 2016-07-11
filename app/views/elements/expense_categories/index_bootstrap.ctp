
<?php
    $i = 0;
    foreach ($expensesCategories as $expensesCategory):
        $class = null;
        if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
        }
    ?>

        <div class="row">
            <div class="col-sm-12">
                <?php echo $html->link(__($expensesCategory['ExpensesCategory']['name'], true), array('controller'=>'expenses_categories',
                'action'=>'view', $expensesCategory['ExpensesCategory']['id'])); ?>
            </div>

        </div>
</tr>
<?php endforeach; ?>
