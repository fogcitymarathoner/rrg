<div class="clientsChecks form">
<?php
//debug($step);
if($step==1)
{
echo $form->create('ClientsCheck',array('url' => array('controller'=>'clients','action'=>'add_check/'.$clientData['Client']['id'].'/2'))); ?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
 		<table>
	<?php
		echo $form->input('client_id', array('type'=>'hidden','value'=>$clientData['Client']['id']));
		echo '<tr><td>';
		echo $form->input('number', array('size'=>12));
		echo '</td></tr><tr>';
		echo '<td>';
        $dateexplode = explode('-',date( 'Y-m-d'));
        $javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; //debug($javadate);
    ?>
<p><label for="call_date">Date</label> : <input type="text" class="w16em" id="check_date" name="data[ClientsCheck][date]" value="<?php echo $javadate; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"check_date":"m-sl-d-sl-Y"}                  
        };        
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      <?php 
		echo '</td></tr>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		echo $form->input('notes', array('size'=>70));
		echo '</td>';
		echo '</tr>';
		?>
		</table>

	</fieldset>
<?php echo $form->end('Submit');
}elseif($step==2)
{
    echo $this->element('checks/add_step_2', array( 'webroot'=>$this->webroot));
}elseif($step==3)
{
	?> 
	<h3>Verify invoices to credit for <?php echo $clientData['Client']['name'];?></h3>
	<table> 
	<?php
	echo $form->create('ClientsCheck',array('url' => array('controller'=>'clients','action'=>'add_check/'.$this->data['ClientsCheck']['client_id'].'/4')));
		echo '<tr>';
		echo '<td>';
		echo $form->input('client_id', array('type'=>'hidden','value'=>$this->data['ClientsCheck']['client_id']));
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		echo "This 'Amount' is a calculation.  Replaced by the sum of the values below.";
		echo $form->input('amount', array('readonly'=>true,'value'=>sprintf('%8.2f',round($this->data['ClientsCheck']['amount'],2)),'size'=>12));
		echo '</td></tr>';
		echo '<tr>';
		echo '<td>';
		echo $form->input('number', array('value'=>$this->data['ClientsCheck']['number'],'size'=>12));
		echo '</td></tr>';
		echo '<tr><td>';
?>
<p><label for="call_date">Date</label> : <input type="text" class="w16em" id="check_date" name="data[ClientsCheck][date]" value="<?php echo $this->data['ClientsCheck']['date']; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"check_date":"m-sl-d-sl-Y"}                  
        };        
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      <?php 
		
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		echo $form->input('notes', array('value'=>$this->data['ClientsCheck']['notes'],'size'=>70));
		echo '</td>';
		echo '</tr>';
		?>
		</table>
		<table>
		<tr>
		<th>Invoice No.</th>
		<th>Date</th>
		<th>Start</th>
		<th>End</th>
		<th>Inv. Amount</th>
		<th>Balance</th>
		<th>Notes</th>
		</tr>

<?php
$i = 0;
foreach ($this->data['ClientsCheck']['Invoice'] as $invoice):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	?>
		<tr<?php echo $class;?>>
		<td>
			<?php echo $invoice['id']; ?>
		</td>
		<td>
			<?php echo $rapp->regularDateDisplay($invoice['date']); ?>
		</td>
		<td>
			<?php echo $rapp->regularDateDisplay($invoice['period_start']); ?>
		</td>
		<td>
			<?php echo $rapp->regularDateDisplay($invoice['period_end']); ?>
		</td>
		<td>
			<?php echo sprintf('%8.2f',round($invoice['amount'],2)); ?>
		</td>
		<td align="right">
			<?php 
			echo $form->input('created_user_id',array('type'=>'hidden', 'value'=>$currentUser));
			
			//echo $form->input('Invoice.invoice_id', array(name=>'data[Invoice][Invoice][]','label'=>'','value'=>sprintf('%8.2f',round($invoice['Invoice']['balance'],2))));
?>
<input  type="hidden" name="data[Invoice][InvoiceId][][id]" value="<?php echo $invoice['id']; ?>" id="InvoiceInvoice<?php echo $invoice['id']; ?>" />
<input  name="data[Invoice][InvoiceAmount][][amount]" size=7 value="<?php echo sprintf('%8.2f',round($invoice['balance'],2)); ?>" id="InvoiceInvoice<?php echo $invoice['id']; ?>" />
		</td>
		<td>
			<?php echo $invoice['notes']; ?>
		</td>
	</tr>
	<tr>
	<td></td>
	<td colspan=6>
	<table border="1">
	<tr>
	<th colspan=4>Previous Payments</th>
	</tr>
	<tr>
	<th>Check No.</th>
	<th>Amount</th>
	<th>Notes</th>
	</tr>
	<tr>

	<?php
		$paymenttotal = 0;
		if(!empty($invoice['InvoicesPayment']))
		{
            //debug($invoice['InvoicesPayment']);exit;
            foreach ($invoice['InvoicesPayment'] as $payment):
            ?>
                <td><?php echo $payment['number'];?></td>
                <td align=right ><?php echo sprintf('%8.2f',round($payment['amount'],2));?></td>
                <td><?php echo $payment['notes'];?></td>
                </tr>
            <?php
                $paymenttotal += $payment['amount'];
            endforeach;
		}
	?>
	<tr><td>Total</td><td align=right ><?php echo sprintf('%8.2f',round($paymenttotal,2));?></td><td></td></tr>
	</table>
	</td>
	</tr>
	<?php
endforeach; 

echo $form->end('Submit');

}	

?>
</table>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Client', true), array('controller'=>'clients','action' => 'view_checks',$clientData['Client']['id']));?></li>
	</ul>
</div>
