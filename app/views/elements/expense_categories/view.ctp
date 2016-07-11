
<div class="related">
    <h3><?php __('Related Expenses');?></h3>
    <?php
            //debug($expenses);

    if (!empty($expenses)):?>
        <table cellpadding = "1" cellspacing = "0" border=1>
            <tr>
                <th><?php __('Date'); ?></th>
                <th><div style="border: solid 0 #060;  padding-left:0.5ex; padding-right:0.5ex;"><?php __('Amount'); ?></div></th>
                <th><?php __('Description'); ?></th>
                <th><?php __('Notes'); ?></th>
                <th class="actions"><?php __('Actions');?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($expenses as $expense):
            //debug($expense);
            $class = null;
            if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
            }
            ?>
                <tr<?php echo $class;?>>
                <td><div style="border: solid 0 #060;  padding-left:0.5ex; padding-right:0.5ex"><?php echo date('m/d/Y',strtotime($expense['Expense']['date']));?></div></td>
                <td align=right><div style="border: solid 0 #060;  padding-left:0.5ex;  "><?php echo sprintf('%01.2f',$expense['Expense']['amount']);?></div></td>
                <td><div style="border: solid 0 #060;  padding-left:0.5ex;  padding-right:0.5ex"><?php echo $expense['Expense']['description'];?></div></td>
                <td><div style="border: solid 0 #060; padding-left:0.5ex; padding-right:0.5ex"><?php echo $expense['Expense']['notes'];?></div></td>
                <td class="actions">
                    <?php echo $html->link(__('Dup', true), array('controller'=> 'expenses_categories', 'action'=>'dup_exp',$expense['Expense']['id'])); ?>
                    <?php echo $html->link(__('View', true), array('controller'=> 'expenses_categories', 'action'=>'view_exp', $expense['Expense']['id'])); ?>
                    <?php echo $html->link(__('Edit', true), array('controller'=> 'expenses', 'action'=>'edit_exp', $expense['Expense']['id'])); ?>
                    <?php echo $html->link(__('Delete', true), array('controller'=> 'expenses_categories', 'action'=>'delete_exp', $expense['Expense']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $expense['Expense']['id'])); ?>
                </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
