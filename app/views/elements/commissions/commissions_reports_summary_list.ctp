<h3><?php __('Employees Commissions Reports');?></h3>
<?php if (!empty($reports)):?>
<table cellpadding = "3" cellspacing = "3" border=1 >
    <tr>
        <th><?php __('Period Id'); ?></th>
        <th><?php __('Period'); ?></th>
        <th><?php __('Commissions Balance'); ?></th>
        <th><?php __('Notes Balance'); ?></th>
        <?php if($print == False) {?>
            <th><?php __('Actions'); ?></th>
        <?php } ?>
    </tr>
    <?php
		$i = 0;
		$total = 0;
		foreach ($reports as $employeesCommTag):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
    <tr<?php echo $class;?>>
    <td><?php echo $employeesCommTag['CommissionsReportsTag']['id'];  ?></td>
    <td><?php echo $employeesCommTag['CommissionsReportsTag']['period'];  ?></td>
    <td align="right"><?php echo sprintf('%8.2f',round($employeesCommTag['CommissionsReportsTag']['comm_balance'],2));  ?></td>
    <td align="right"><?php echo sprintf('%8.2f',round($employeesCommTag['CommissionsReportsTag']['note_balance'],2));  ?></td>
    <?php if($print == False) {?>
        <td align=right >
        <?php if (!$employeesCommTag['CommissionsReportsTag']['cleared']){?>
                <?php echo $html->link(__('View', true), array('action' => 'view_commissions_tagged_report', $employeesCommTag['CommissionsReportsTag']['id'])); ?>

        <?php } else { ?>
            <?php echo 'View'; ?>
            <?php } ?>
        </td>
        <td align=right >
            <?php echo $html->link(__('View Archive', true), array('action' => 'view_commissions_xmltagged_report', $employeesCommTag['xml_report']['id'])); ?>
        </td>
    <?php } ?>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
