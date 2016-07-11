<?php //$name = $employee['firstname'].' '.$employee['lastname'];?>
<div data-role="header">
    <h3>
        <?php
            if($type == 'view')
            {
                echo 'View Expense';
            }

        ?>
    </h3>
    <div id='buttons'>
        <a href="<?php echo $this->webroot?>m/expenses/"  data-role="button" data-inline="true" data-icon="left_arrow">Back to Expenses</a>

        <?php
                if($type == 'view')
                {
                ?>
        <a href="<?php echo $this->webroot?>m/expenses/edit/<?php echo $expense['id']?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Edit</a>

        <a href="<?php echo $this->webroot?>m/expenses/dup/<?php echo $expense['id']?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Dup</a>

        <a href="<?php echo $this->webroot?>m/expenses/delete/<?php echo $expense['id']?>"   data-role="button" data-inline="true" data-icon="delete">Delete</a>
        <?php
    }

    ?>
    </div>
</div>
