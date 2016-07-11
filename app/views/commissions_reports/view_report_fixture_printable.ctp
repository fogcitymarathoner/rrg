
<h3>Commissions Items</h3>
<table cellpadding="1" cellspacing="1">
<tr>
	<th>Date</th>
	<th>Description</th>
	<th>Amount</th>
</tr>
<?php
$i = 0;
foreach ($commItems['InvoicesItemsCommissionsItem'] as $item)://debug($item);
	if ($item['amount']>0)
	{
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
			echo date('m/d/Y',strtotime($item['date'])); ?>
		</td>
		<td width=600px>
			<?php //$html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id']))
			echo str_pad($item['description'],20,'_').'-'.$item['period'].
			'-'.$item['description'];
			 ?>
		</td>
		<td align="right">
			<?php 
			//echo sprintf('%8.2f',round($item['amount'],2));
			?>
		</td>
	</tr>
    <tr<?php echo $class;?>>
            <td>

            </td>
            <td width=600px>
            <?php //$html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id']))
                    echo $item['percent'].'% ';
                    echo " line amt: ".$item['rel_inv_line_item_amt'];
                    echo " invoice amt: ".$item['rel_inv_amt'];
                    echo " quantity: ".$item['rel_item_quantity'];
                    echo " DLR: ".$item['rel_item_cost'];
                    echo " Billout: ".$item['rel_item_amt'];                    ?>
        </td>
<td align="right">
<?php
        echo sprintf('%8.2f',round($item['amount'],2));
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
	<th>Date</th>
	<th>Description</th>
	<th>Amount</th>
</tr>
<?php
$i = 0;
foreach ($commPayments['CommissionsPayment'] as $payment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<tr<?php echo $class;?>>
<td>
    <?php
            echo date('m/d/Y',strtotime($payment['date'])); ?>
</td>
<td width=600px>
<?php
        echo $payment['description']; ?>
</td>
<td align="right">
<?php
        echo sprintf('%8.2f',round($payment['amount'],2)); ?>
</td>
        </tr>
<?php 

endforeach; ?>
</table>
