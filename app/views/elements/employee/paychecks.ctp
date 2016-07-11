	<?php //debug($paychecks);exit;
	if (!empty($paychecks)):?>
	<table cellpadding = "3" cellspacing = "3" border=1 >
	<tr>
		<th><?php __('Invoice Number'); ?></th>
		<th><?php __('Date'); ?></th>
		<th  colspan=2><?php __('Period'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		$total = 0;
		foreach ($paychecks as $employeesPaycheck):
			if ($employeesPaycheck['Paycheck']['display'])
			{
				$class = null; 
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td><?php
                        echo '#'.$i.' ';
                        echo $employeesPaycheck['Paycheck']['invoice_id'];?></td>
				<td><?php echo date('m/d/Y',strtotime($employeesPaycheck['Paycheck']['date']));?></td>
				<td colspan=2 ><?php echo date('m/d/Y',strtotime($employeesPaycheck['Paycheck']['period_start'])).
				'-'.date('m/d/Y',strtotime($employeesPaycheck['Paycheck']['period_end']));?></td>
	
				<td align=right ><?php echo number_format  ($employeesPaycheck['Paycheck']['amountdue'],2); 
				$total+=$employeesPaycheck['Paycheck']['amountdue'] ;?></td>
	
				<td>
			<?php
                    if($printable == 0)
                    {
                    echo $html->link(__('Edit Invoice Notation', true), array('action' => 'edit_invoice',$employeesPaycheck['Paycheck']['invoice_id'],'next'=>$next));
                    }
                ?>
			</td>
			</tr>
        <tr<?php echo $class;?>>
        <td>Invoice notes</td>
        <td colspan=5 ><?php echo $employeesPaycheck['Paycheck']['notes'];?></td>
        </tr> 
        <tr<?php echo $class;?>>
        <td>REF</td>
        <td colspan=5 ><?php echo $employeesPaycheck['Paycheck']['ref'];?></td>
        </tr>

        <?php
                            //debug($employeesPaycheck);exit;
   if($employeesPaycheck['Paycheck']['payroll_id'])
   {
   ?>
            <tr<?php echo $class;?>>
            <td>Payroll</td>
            <td colspan=5 >
                    <?php
                            //debug($employeesPaycheck);exit;
                                echo $html->link(__('View Payroll', true), array('controller'=>'payrolls','action' => 'view',
                            $employeesPaycheck['Paycheck']['payroll_id']));
                    ?>
                            </td>
            </tr>
        <?php }?>
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
				<td><?php echo '----';?></td>	
				<td><?php echo $item['description'];?></td>	
				<td><?php echo $item['quantity'];?></td>	
				<td align=right><?php echo $item['cost'];?></td>		
				<td align=right><?php echo sprintf('%8.2f',round($item['cost']*$item['quantity']));?></td>	
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
			
				<tr<?php echo $class;?>>
				<td colspan=6 align=right>
				
			<table cellpadding = "3" cellspacing = "3" border=1 >
				<tr<?php echo $class;?>>
				
			<th><?php __('Date'); ?></th>
			<th><?php __('Ref'); ?></th>
			<th><?php __('Amount'); ?></th>
			<th><?php __(''); ?></th>
<?php
        if($printable == 0)
        { ?>
			<th><?php __('Actions');
                    ?></th>
        <?php
                }
        ?>
				</tr>
				<?php
				foreach ($employeesPaycheck['Paycheck']['Payments'] as $payment): 
			//debug($payment);exit;
			?>
        </tr>
			<tr<?php echo $class;?>>
			<td>
				<?php echo $payment['EmployeesPayment']['date'];?>
			</td>
			<td>
				<?php echo $payment['EmployeesPayment']['ref'];?>
			</td>
			<td align=right>
				<?php echo number_format  ($payment['EmployeesPayment']['amount'],2);?>
			</td>
			<td>
			</td>
			<td>
			<?php
                    if($printable == 0)
                    {
                    echo $html->link(__('Edit Payment', true), array('action' => 'edit_payment',$payment['EmployeesPayment']['id'],'next'=>$next));
			        }
                    ?>
			</td>
			<?php//debug ($payment);?>
			</tr>
			<tr<?php echo $class;?>>
			<td>Notes
			</td>
			<td colspan=5>
				<?php echo $payment['EmployeesPayment']['notes'];?>
			</td>
	
			</tr>
			<?php
				endforeach;
				?>

			</table>
				</td>
				</tr>
				<?php
			} ?>
			<?php
		}
			?>
	<?php endforeach; ?>
	</table>
<?php
            echo 'Total: '.number_format  ($total,2);
        endif;
        ?>
