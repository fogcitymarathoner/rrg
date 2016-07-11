
<?php

        foreach ($expenses as $expense):
        echo "<li>";
        //debug($expense['ExpensesCategory']['name']);
        ?>
<div data-role="controlgroup">
<a href="<?php echo $this->webroot?>m/expenses/view/<?php echo $expense['Expense']['id']?>" data-rel="dialog" data-inline="true" data-role='button' data-icon='check'><?php echo __($expense['Expense']['description'], true)?> - <?php echo __($expense['Expense']['date'], true)?> - <?php echo __($expense['Expense']['amount'], true)?></a>
</div>
        <?php echo $expense['Expense']['notes']?>
        <?php echo "</li>";
        endforeach;

?>
