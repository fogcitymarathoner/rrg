<?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
<br>
    <br>

<h3>Commissions Items</h3>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
            <li><?php echo $html->link(__('Printable', true), array('action'=>'view_commissions_tagged_report_printable',$report_id ));?></li>
        </ul>
    </div>
<table cellpadding="1" cellspacing="1">
<tr>
	<th>Date</th>
	<th>Description</th>
	<th>Amount</th>
</tr>
<?php
$i = 0;
foreach ($commItems as $item)://debug($item);
	if ($item['InvoicesItemsCommissionsItem']['amount']>0)
	{
	//debug($item);
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
			echo date('m/d/Y',strtotime($item['InvoicesItemsCommissionsItem']['date'])); ?>
		</td>
		<td width=600px>
			<?php //$html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id']))
			echo $html->link(__(str_pad($item['InvoicesItemsCommissionsItem']['description'],20,'_'), true), array('action'=>'view', 'controller'=>'invoices',
			$item['InvoicesItem']['Invoice']['id'])).'-'.
			date('m/d/Y',strtotime($item['InvoicesItem']['Invoice']['period_start'])).'-'.date('m/d/Y',strtotime($item['InvoicesItem']['Invoice']['period_end'])).'-'.$item['InvoicesItem']['description'];
			 ?>
		</td>
		<td align="right">
			<?php 
			//echo sprintf('%8.2f',round($item['InvoicesItemsCommissionsItem']['amount'],2));
			?>
		</td>
	</tr>
    <tr<?php echo $class;?>>
            <td>

            </td>
            <td width=600px>
            <?php //$html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id']))
                    echo $item['InvoicesItemsCommissionsItem']['percent'].'% ';
                    echo " line amt: ".$item['InvoicesItemsCommissionsItem']['rel_inv_line_item_amt'];
                    echo " invoice amt: ".$item['InvoicesItemsCommissionsItem']['rel_inv_amt'];
                    echo " quantity: ".$item['InvoicesItemsCommissionsItem']['rel_item_quantity'];
                    echo " DLR: ".$item['InvoicesItemsCommissionsItem']['rel_item_cost'];
                    echo " Billout: ".$item['InvoicesItemsCommissionsItem']['rel_item_amt'];                    ?>
        </td>
<td align="right">
<?php
        echo sprintf('%8.2f',round($item['InvoicesItemsCommissionsItem']['amount'],2));
        ?>
</td>
        </tr>
<?php 
	}
endforeach; ?>
</table>

<h3>Commissions Payments</h3>
<table cellpadding="1" cellspacing="1">
<tr>
	<th>Id</th>
	<th>Date</th>
	<th>Description</th>
	<th>Amount</th>
</tr>
<?php
$i = 0;
foreach ($commPayments as $payment): //debug($payment);
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<tr<?php echo $class;?>>
	<td width=20px>
		<?php echo $payment['CommissionsPayment']['id']; ?>
	</td>
	<td>
		<?php echo date('m/d/Y',strtotime($payment['CommissionsPayment']['date'])); ?>
	</td>
	<td width=600px>
		<?php echo $payment['CommissionsPayment']['description']; ?>
	</td>
	<td align="right">
		<?php echo sprintf('%8.2f',round($payment['CommissionsPayment']['amount'],2)); ?>
	</td>
</tr>
<?php 

endforeach; ?>
</table>

<ul>
<li><?php echo $html->link(__('Printable', true), array('action'=>'view_commissions_tagged_report_printable',$report_id ));?></li>
</ul>