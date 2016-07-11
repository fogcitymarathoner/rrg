<?

		//debug($commItems);
		//debug($commPayments);
		?>

        <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
        <br>
        <?php
                /*
                echo $this->element('employee_payment_menu', array(
        							'employee'=>$employee['Employee'],
        							'webroot'=>$this->webroot,
        							));
                */
        ?>
        <br><h3>Notes Items</h3>
<table cellpadding="1" cellspacing="1">
<tr>
	<th>ID</th>
	<th>Date</th>
	<th>Description</th>
	<th>Amount</th>
</tr>
<?php
$i = 0;
foreach ($notes as $item):
	if ($item['Note']['amount']>0)
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
			echo $item['Note']['id']; ?>
		</td>
		<td>
			<?php 
			echo date('m/d/Y',strtotime($item['Note']['date'])); ?>
		</td>
		<td width=600px>
			<?php //debug ($item);exit;
			//$html->link(__('Return to Employee', true), array('action'=>'view_notes', $this->data['Note']['employee_id']))
			echo str_pad($item['Note']['notes'],20,'_');
			//echo $html->link(__(str_pad($item['Note']['notes'],20,'_'), true), array('action'=>'view', 'controller'=>'invoices',
			//$item['InvoicesItem']['Invoice']['id'])).'-'.
			//date('m/d/Y',strtotime($item['InvoicesItem']['Invoice']['period_start'])).'-'.date('m/d/Y',strtotime($item['InvoicesItem']['Invoice']['period_end'])).'-'.$item['InvoicesItem']['description'];
			 ?>
		</td>
		<td align="right">
			<?php 
			echo sprintf('%8.2f',round($item['Note']['amount'],2)); 
			?>
		</td>
	</tr>
<?php 
	}
endforeach; ?>
</table>

<h3>Notes Payments</h3>
<table cellpadding="1" cellspacing="1">
<tr>
	<th>ID</th>
	<th>Date</th>
	<th>Check Number</th>
	<th>Description</th>
	<th>Amount</th>
</tr>
<?php
$i = 0;
foreach ($notePayments as $payment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td >
			<?php  //debug($payment);
			echo $payment['NotesPayment']['id']; ?>
		</td>
		<td>
			<?php 
			echo date('m/d/Y',strtotime($payment['NotesPayment']['date'])); ?>
		</td>
		<td>
			<?php 
			echo $payment['NotesPayment']['check_number']; ?>
		</td>
		<td width=600px>
			<?php 
			echo $payment['NotesPayment']['notes']; ?>
		</td>
		<td align="right">
			<?php 
			echo sprintf('%8.2f',round($payment['NotesPayment']['amount'],2)); ?>
		</td>
	</tr>
<?php 

endforeach; ?>
</table>
		