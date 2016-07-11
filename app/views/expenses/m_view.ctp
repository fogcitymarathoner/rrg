<?php
        //debug($expense); exit;?>
<?php echo $this->element('m_expense_dialog_header',array('type'=>'view', 'expense'=>$expense['Expense']));?>
<div data-role="content">
    <ul data-role="listview">

        <?php

                echo "<li>";
                echo $expense['ExpensesCategory']['name'];
                echo "</li>";

                echo "<li>";
                echo $expense['Employee']['firstname'].' '.$expense['Employee']['lastname'];
                echo "</li>";

                echo "<li>";
                echo $expense['Expense']['date'];
                echo "</li>";

                echo "<li>";
                echo $expense['Expense']['description'];
                echo "</li>";
                echo "<li>";
                echo $expense['Expense']['notes'];
                echo "</li>";
                ?>

</ul>
</div>
