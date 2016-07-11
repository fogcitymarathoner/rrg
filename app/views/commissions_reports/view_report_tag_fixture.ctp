<?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
<br>
    <br>

<h3>Commissions Items</h3>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Return to Reports Index', true), array('action'=>'index'));?></li>
            <li><?php echo $html->link(__('Printable', true), array('action'=>'view_report_fixture_printable',$report_id ));?></li>
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
foreach ($commItems['InvoicesItemsCommissionsItem'] as $item)://debug($item);
	if ($item['amount']>0)
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
			echo date('m/d/Y',strtotime($item['date'])); ?>
		</td>
		<td width=600px>
			<?php //$html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id']))
			echo $html->link(__(str_pad($item['description'],20,'_'), true), array('action'=>'view', 'controller'=>'invoices',
			$item['invoice_id'])).'-'.$item['period'].
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
foreach ($commPayments['CommissionsPayment'] as $payment): //debug($payment);
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

<ul>
<li><?php echo $html->link(__('Printable', true), array('action'=>'view_commissions_xmltagged_report_printable',$report_id ));?></li>
</ul>