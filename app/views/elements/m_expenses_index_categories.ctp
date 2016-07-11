
<?php

        foreach ($expensesCategories as $expenseCategory):
        echo "<li>";
        //debug($expense['ExpensesCategory']['name']);
        ?>
<div data-role="controlgroup">
<a href="<?php echo $this->webroot?>m/expenses/view_expenseCategory/<?php echo $expenseCategory['ExpensesCategory']['id']?>" data-rel="external" data-inline="true" data-role='button' data-icon='check'><?php echo __($expenseCategory['ExpensesCategory']['name'], true)?> </a>
</div>
        <?php echo "</li>";
        endforeach;

?>
