	<?php //debug($paychecks);exit;
	if (!empty($paychecks)):?>
	<table cellpadding = "3" cellspacing = "3" border=1 >
	<tr>
		<th  colspan=2><?php __('Week Ending'); ?></th>
		<th><?php __('Hours'); ?></th>
		<th><?php __('Rate'); ?></th>
		<th><?php __('Gross'); ?></th>
	</tr>
	<?php
		$i = 0;
		$total = 0;
		foreach ($paychecks as $employeesPaycheck): 
			//debug($employeesPaycheck);exit;
			if ($employeesPaycheck['Paycheck']['display'])
			{
				$class = null; 
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<?php
			//debug($employeesPaycheck['Paycheck']);exit;
			if(!empty($employeesPaycheck ['Paycheck']['InvoicesItem'] ))
			{
			?>
			<?php
				foreach ($employeesPaycheck ['Paycheck']['InvoicesItem'] as $item): 
					if($item['cost']*$item['quantity'])
					{
				?>
				<tr<?php echo $class;?>>
				<td colspan=2 ><?php echo date('m/d/Y',strtotime($employeesPaycheck['Paycheck']['period_end']));?></td>
				<td><?php echo $item['quantity'];?></td>	
				<td align=right><?php echo $item['cost'];?></td>		
				<td align=right><?php echo sprintf('%8.2f',round($item['cost']*$item['quantity']));
				$total += $item['cost']*$item['quantity'];
				?></td>
				</tr>
				<?php 
				}
				endforeach; //debug($item);exit;?>
			<?php
			}
			?>
			<?php
			//debug($employeesPaycheck['Paycheck']['Payments']);exit;
			if(!empty($employeesPaycheck['Paycheck']['Payments'] ))
			{
			?>
			

				<?php
			} ?>
			<?php
		}
			?>
	<?php endforeach; ?>
	</table>
<?php endif; 
echo 'Total: '.number_format  ($total,2);
?>
