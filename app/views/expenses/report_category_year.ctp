<div class="expenses index">
<h2><?php 
__($expensecategory[0]['ExpensesCategory']['name'].' Expenses for '.$year);?></h2>
    <table cellpadding="0" cellspacing="0" border=1>
    <tr>
        <th>Employee</th>
        <th><?php echo 'Amount';?></th>
        <th><?php echo 'Date';?></th>
        <th><?php echo 'Description';?></th>
        <th><?php echo 'Notes';?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($expenses as $expense):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
            <td>
                <?php echo $expense['Employee']['firstname'].' '.$expense['Employee']['lastname']; ?>
            </td>
            <td>
                <?php echo $expense['Expense']['amount']; ?>
            </td>
            <td>
                <?php echo $expense['Expense']['date']; ?>
            </td>
            <td>
                <?php echo $expense['Expense']['description']; ?>
            </td>
            <td>
                <?php echo $expense['Expense']['notes']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
            <td>		</td>
            <td><b>
                <?php echo $annualtotal; ?>
                </b>
            </td>
    </tr>
    </table>
</div>