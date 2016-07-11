<div class="actions">
    <ul>
        <li><?php echo $html->link(__('PRINT', true), array('controller'=> 'expenses', 'action'=>'report_year','year'=>$year,
                'print'=>'True')); ?> </li>
        <li><?php echo $html->link(__('Select Different Year', true), array('controller'=> 'expenses', 'action'=>'select_year'));?></li>

    </ul>
</div>
<div class="expenses index">
    <h2>
        <?php  __(' Expenses for '.$year);?>
        <?php echo $expenses[0]['Employee']['firstname'].' '.$expenses[0]['Employee']['lastname']; ?>
    </h2>
    <table cellpadding="0" cellspacing="0" border=1>
        <tr>
            <th><?php echo 'Expense';?></th>
            <th><?php echo 'Amount';?></th>
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
            <td><?php echo $expense['ExpensesCategory']['name'];?></td>
            <td align=right><?php echo sprintf('%8.2f',round($expense[0]['amount'],2));?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan=2 align=right><b><?php echo sprintf('%8.2f',round($annualtotal,2));?></b></td>
        </tr>

    </table>
</div>
<p>
date_generated = <?php echo date('D, d M Y H:i:s');?>
</p>