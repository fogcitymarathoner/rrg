<div class="invoices index">
<h2><?php echo $page_title;?></h2>
<p>

<?php echo $html->link(__('Return to payrolls', true), array('action'=>'index')); ?>|
Queued Invoices add up to <? echo $payrolltotal;?>
</p>
<form id="PostAddForm" method="post" action="verified">
<input type="hidden" name="_method" value="POST" />


<?php	
		$dateexplode = explode('-',date('d-m-Y'));
		$javadate = $dateexplode[1].'/'.$dateexplode[0].'/'.$dateexplode[2]; 
		?>
<p><label for="payroll_date">Date</label> : <input type="text" class="w16em" id="date" name="data[Payroll][date]" value="<?php echo $javadate; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"date":"m-sl-d-sl-Y"}                  
        };        
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      

<input TYPE=HIDDEN name="data[Payroll][amount]" value="<? echo $payrolltotal;?>" type="text"  id="PayrollAmount"  >
<br>
<label for="PayrollNumber">Name</label>
<input name="data[Payroll][name]" type="text" maxlength="50"  size="35" id="PayrollName" />
<br>
<label for="PayrollNumber">Notes</label>

<input name="data[Payroll][notes]" type="text" maxlength="100"  size="80" id="PayrollNotes" />
<table cellpadding="1" cellspacing="1" border=1>
	<tr>
	<th>Paystubs</th>

	</tr>

<?php
if(!empty($paychecks))
{
	$i = 0;
	foreach ($paychecks as $pay):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>
		<tr<?php echo $class;?>>
		<td colspan=4><b>
		<input TYPE=HIDDEN name="data[Payroll][Paycheck][]" value="<?php echo $pay['Invoice']['id']?>" id="PaycheckPaycheck<?php echo $pay['Invoice']['id']?>" >

<?php echo date('m/d/Y',strtotime($pay['Invoice']['period_start']))?>-<?php echo date('m/d/Y',strtotime($pay['Invoice']['period_end']))?>:
	<?php
							$res =  '<b>'.$pay['Employee']['firstname'].' ';
							if($pay['Employee']['nickname']!='')
							{
								$res .=  '('.$pay['Employee']['nickname'].') ';
							}
							$res .=  $pay['Employee']['lastname'].'</b>';
							echo $res;
	?>

:$<?php echo $pay['Invoice']['emp_balance']?>:
:notes - <?php echo $pay['Invoice']['notes']?>:direct deposit - <?php echo $pay['Employee']['directdeposit']?>:</td>	
</b></tr>
<?php
if(!empty($pay['InvoicesItem']) )
{
	$j = 0;
	foreach ($pay['InvoicesItem'] as $payitem):
		
//debug($payitem);
			if($payitem['quantity']*$payitem['cost'] )
			{
?>
		<tr<?php echo $class;?>>
	<td>

<?php echo $payitem['description']?>:</td>	
	<td>

<?php echo 'Hours:<b>'.$payitem['quantity'].'</b>'?>:</td>	
	<td>

<?php echo $payitem['cost']?>:</td>	
	<td>

<?php echo '<b>'.number_format  ($payitem['quantity']*$payitem['cost'],2).'</b>'?>:</td>	
<?php 
		}
endforeach; ?>
</tr>
<?php
}?>
<?php	
	endforeach; 
}else
{
	echo '<td colspan="2">No payments</td>';
}
?>
<tr><td>
<input type="submit" value="Submit" />
</td></tr>
</form>	
</table>