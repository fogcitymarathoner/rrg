

<table cellpadding="0" cellspacing="0">
    <tr>
        <?php if($displayActions==TRUE)
                {
                ?>
        <th><?php __('name');?></th>
        <th class="actions"><?php __('Actions');?></th>
        <?php } ?>
    </tr>
    <?php
            $i = 0;
            foreach ($expensesCategories as $expensesCategory):
            $class = null;
            if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
            }
            ?>
    <tr<?php echo $class;?>>
    <td>
        <?php echo $html->link(__($expensesCategory['ExpensesCategory']['name'], true), array('action'=>'view', $expensesCategory['ExpensesCategory']['id'])); ?>
    </td>
    <?php if($displayActions==TRUE)
            {
            ?>
    <td class="actions">
        <?php echo $html->link(__('Edit', true), array('action'=>'edit', $expensesCategory['ExpensesCategory']['id'])); ?>
        <?php echo $html->link(__('Delete', true), array('action'=>'delete', $expensesCategory['ExpensesCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $expensesCategory['ExpensesCategory']['id'])); ?>
    </td>
    <?php } ?>
</tr>
        <?php endforeach; ?>
        </table>