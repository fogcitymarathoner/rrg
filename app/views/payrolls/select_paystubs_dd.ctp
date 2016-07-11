<div class="invoices index">
<h2><?php echo $page_title;?></h2>
<p>
<?php echo $html->link(__('Return to payrolls', true), array('action'=>'index')); ?>
</p>
<form id="PostAddForm" method="post" action="verify">
<div class="paystubs index">

<table cellpadding="1" cellspacing="1" border=1>
	<tr>
	<th>Direct Deposits --- Period:Employee:Amount</th>
	</tr>
<?php
if(!empty($ddpaychecks))
{
	$i = 0;
	foreach ($ddpaychecks as $pay):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
		<tr<?php echo $class;?>>
	<td>
	<input type="checkbox" name="data[Paycheck][Paycheck][]" value="<?php echo $pay['Paycheck']['invoice_id']?>" id="PaycheckPaycheck<?php echo $pay['Paycheck']['invoice_id']?>" />
	<label for="PaycheckPaycheck<?php echo $pay['Paycheck']['invoice_id']?>"><?php echo date('m/d/Y',strtotime($pay['Paycheck']['period_start']))?>-<?php echo date('m/d/Y',strtotime($pay['Paycheck']['period_end']))?>:

	<?php
							$res =  '<b>'.$pay['Paycheck']['firstname'].' ';
							if($pay['Paycheck']['nickname']!='')
							{
								$res .=  '('.$pay['Paycheck']['nickname'].') ';
							}
							$res .=  $pay['Paycheck']['lastname'].'</b>';
							echo $res;
	?>
	

	:$<?php echo $pay['Paycheck']['balance']?>:Notes -- <?php echo $pay['Paycheck']['notes']?>:</label>
	        </td>	</tr>
	<?php endforeach; 
} else
{
	echo '<td colspan="2">No check payments</td>';
}
?>
</table>
</div>
<input type="submit" value="Submit" />

</form>	
