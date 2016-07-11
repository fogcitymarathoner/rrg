<script type="text/javascript">

  function MyCalc(){ 
    var rows = document.getElementById('invTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    var total = 0;
    for (i = 1; i < rows.length-1; i++) {

  		document.invoice_form["data[Item]["+i+"][subtotal]"].value = 
  											Math.round(parseFloat(document.invoice_form["data[Item]["+i+"][amount]"].value *
  												document.invoice_form["data[Item]["+i+"][quantity]"].value*100))/100;
  		total = total + Math.round(parseFloat(document.invoice_form["data[Item]["+i+"][subtotal]"].value));
    }
	document.invoice_form["grandtotal"].value = total;
  }

</script>
<div class="clientseditinvoice form">

<?php if($step == 1){ ?>

	<fieldset>
<?php 
//debug($this->data['ClientsContract']);exit;
echo $form->create('Reminders',array('action'=>'edit_invoice/2/'.$this->data['Invoice']['id'],'name'=>'invoice_form'));?>
	<fieldset>
 		<legend><?php __('Edit Invoice');?></legend>
		<?php
		echo '<h3>'.$this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'].'</h3>';
		echo '<h3>'.$this->data['Client']['Client']['name'].'</h3>';
			if(!empty($this->data['InvoiceItems']))
	{
		foreach($this->data['InvoiceItems'] as $item)
		{
			if($item['InvoicesItem']['quantity']>0)
			{
				echo $item['InvoicesItem']['description'];
				echo '<br>';
				echo $item['InvoicesItem']['quantity'];
				echo '<br>';
				echo $item['InvoicesItem']['cost'];
				echo '<br>';
				echo $item['InvoicesItem']['amount'];
				echo '<br>';
				if(!empty($item['InvoicesItemsCommissionsItem']))
				{
					foreach($item['InvoicesItemsCommissionsItem'] as $citem)
					{
						echo $employees[$citem['employee_id']]; 
						echo $citem['amount']; 
						echo '<br>';
					}
				}
			}
		}
	}
		
		$dateexplode = explode('-',$this->data['Invoice']['date']);
		$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0];

		$dateexplode = explode('-',$this->data['Invoice']['period_start']);
		$javaperiodstart = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0];

		$dateexplode = explode('-',$this->data['Invoice']['period_end']);
		$javaperiodend = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0];
		?>
<p><label for="invoice_date">Date</label> :
<input type="text" class="w16em" id="date" name="data[Invoice][date]" value="<?php echo $javadate; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"date":"m-sl-d-sl-Y"}                  
        };        
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      
      <?php
		echo $form->input('Invoice.po');
		echo $form->input('Invoice.terms');
		echo $form->input('Invoice.id',array('type'=>'hidden'));
		echo $form->input('Invoice.employerexpenserate'); 
		echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>100));
		echo $form->input('ClientsContract.invoicemessage',array('rows'=> 5, 'cols'=>80,'disabled' => "disabled", 
				'label'=>'Invoice Message From Contract',
				'value'=> $this->data['ClientsContract']['invoicemessage']));
		echo $form->input('Invoice.message',array('rows'=> 10, 'cols'=>80));
		//echo $form->input('Invoice.period_start');
		//echo $form->input('Invoice.period_end');
?>
<p><label for="period_start">Period Start</label> :
<input type="text" class="w16em" id="period_start" name="data[Invoice][period_start]" value="<?php echo $javaperiodstart; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[
        var opts = {
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)
                formElements:{"period_start":"m-sl-d-sl-Y"}
        };
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>

<p><label for="invoice_end">Period End</label> :
<input type="text" class="w16em" id="period_end" name="data[Invoice][period_end]" value="<?php echo $javaperiodend; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[
        var opts = {
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)
                formElements:{"period_end":"m-sl-d-sl-Y"}
        };
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      <?php

		echo $form->input('Invoice.voided'); 

		echo $form->input('Invoice.modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('Invoice.contract_id',array('type'=>'hidden'));
		?> 
		<div class="related">
	<h3><?php __('Line Items');?></h3>
	<?php if (!empty($this->data['InvoicesItem'])):?>
	<table cellpadding = "0" cellspacing = "0" id="invTable">
	<tr>
		<th><?php __('Line Item'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Subtotal'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesItem'] as $invoicesItem):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				} 
			?>
			<tr<?php echo $class;?>>
				<td><?php echo 'Item:'.$i;?>
				</td><td>
				<input type="hidden" name="data[Item][<?php echo $i; ?>][id]"  value=<?php echo $invoicesItem['id']?> />
				<input type="hidden" name="data[Item][<?php echo $i; ?>][invoice_id]"  value=<?php echo $invoicesItem['invoice_id']?> />
				<input type="text" name="data[Item][<?php echo $i; ?>][description]"  value=<?php echo $invoicesItem['description']?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][cost]" value=<?php echo $invoicesItem['cost']?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input id="amount" type="text" name="data[Item][<?php echo $i; ?>][amount]" value=<?php echo $invoicesItem['amount']?>  AUTOCOMPLETE="OFF"/>
				</td>
	
				<td>
				<input id="quantity" type="text" name="data[Item][<?php echo $i; ?>][quantity]" value=<?php echo $invoicesItem['quantity']?>  AUTOCOMPLETE="OFF"/>
				</td>			
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][subtotal]" value=<?php echo $invoicesItem['quantity']*$invoicesItem['amount']?>  AUTOCOMPLETE="OFF"/>
				</td>		
			</tr>
		<?php endforeach; ?>
			<tr<?php echo $class;?>>
				<td>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td><input type="button" name="btnCalc" value="Recalculate" onclick="MyCalc()">
				</td>
				<td align="right">Total:
				</td>
				<td align="right">
				<input type="text" name="grandtotal" value=<?php echo $this->data['Invoice']['amount'];?>  AUTOCOMPLETE="OFF"/>
				</td>	
				<td>
				</td>		
			</tr>
		</table>
<?php endif; ?>
		  
	<?php	echo $form->end('Submit');?>		
	</fieldset>

<?php echo $html->link(__('Rebuild', true), array('action'=>'rebuild_invoice', $this->data['Invoice']['id'])); ?>
<?php // END STEP 1
}; ?>


<?php if($step == 2){ ?>
<?php echo $html->link(__('Return to Reminders', true), array('action'=>'timecards')); ?>
<?php echo $html->link(__('Preview', true), array('action'=>'view_invoice_pdf', $this->data['Invoice']['id'])); ?>
	<fieldset>
 		<legend><?php __('Review Invoice #'.$this->data['Invoice']['id']);?></legend>
Client <?php echo '<h3>'.$this->data['Client']['Client']['name'].'</h3>';?>
Employee <?php echo '<h3>'.$this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'].'</h3>';?>
Period <?php echo date("m/d/Y",strtotime($this->data['Invoice']['period_start'])).'-'.date("m/d/Y",strtotime($this->data['Invoice']['period_end']));?><br>
Amount <?php echo $this->data['Invoice']['amount'];?><br>
Notes <?php echo $this->data['Invoice']['notes'];?><br>
Date <?php echo date("m/d/Y",strtotime($this->data['Invoice']['date']));?><br>
Message <?php echo $this->data['Invoice']['message'];?><br>
Terms <?php echo $this->data['Invoice']['terms'];?><br>
EmployerExpenseRate <?php echo $this->data['Invoice']['employerexpenserate'];?><br>
PO <?php echo $this->data['Invoice']['po'];?><br>
<?php 
	if(!empty($this->data['InvoiceItems']))
	{
		foreach($this->data['InvoiceItems'] as $item)
		{
			if($item['InvoicesItem']['quantity']>0)
			{
				echo $item['InvoicesItem']['description'];
				echo '<br>';
				echo $item['InvoicesItem']['quantity'];
				echo '<br>';
				echo $item['InvoicesItem']['cost'];
				echo '<br>';
				echo $item['InvoicesItem']['amount'];
				echo '<br>';
				if(!empty($item['InvoicesItemsCommissionsItem']))
				{
					foreach($item['InvoicesItemsCommissionsItem'] as $citem)
					{
						echo $employees[$citem['employee_id']]; 
						echo $citem['amount']; 
						echo '<br>';
					}
				}
			}
		}
	}
?>

		<div class="related">
	<h3><?php __('Line Items');?></h3>
	<?php if (!empty($this->data['InvoicesItem'])):?>
	<table cellpadding = "0" cellspacing = "0" id="invTable">
	<tr>
		<th><?php __('Item'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Subtotal'); ?></th>
		<th><?php __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesItem'] as $invoicesItem):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				} 
			?>
			<tr<?php echo $class;?>>
				<td><?php echo 'Item:'.$i;?>
				</td><td>
				<input type="hidden" name="data[Item][<?php echo $i; ?>][id]"  value=<?php echo $invoicesItem['id']?> />
				<input type="hidden" name="data[Item][<?php echo $i; ?>][invoice_id]"  value=<?php echo $invoicesItem['invoice_id']?> />
				<input type="text" readonly="readonly" name="data[Item][<?php echo $i; ?>][description]"  value=<?php echo $invoicesItem['description']?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input type="text" readonly="readonly" name="data[Item][<?php echo $i; ?>][cost]" value=<?php echo $invoicesItem['cost']?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input id="amount" readonly="readonly" type="text" name="data[Item][<?php echo $i; ?>][amount]" value=<?php echo $invoicesItem['amount']?>  AUTOCOMPLETE="OFF"/>
				</td>
	
				<td>
				<input id="quantity" readonly="readonly" type="text" name="data[Item][<?php echo $i; ?>][quantity]" value=<?php echo $invoicesItem['quantity']?>  AUTOCOMPLETE="OFF"/>
				</td>			
				<td>
				<input type="text" readonly="readonly" name="data[Item][<?php echo $i; ?>][subtotal]" value=<?php echo $invoicesItem['quantity']*$invoicesItem['amount']?>  AUTOCOMPLETE="OFF"/>
				</td>						
				<td>
				<?php echo $html->link(__('view', true), array('action'=>'view_invoices_item', $invoicesItem['id'])); ?> </li>
				</td>		
			</tr>
		<?php endforeach; ?>
			<tr<?php echo $class;?>>
				<td>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td align="right">Total:
				</td>
				<td align="right">
				<input type="text" readonly="readonly" name="grandtotal" value=<?php echo $this->data['Invoice']['amount'];?>  AUTOCOMPLETE="OFF"/>
				</td>			
			</tr>
		</table>
<?php endif; ?>
		  
	</fieldset>

<?php //END STEP 2 
}; ?>


</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Reminders', true), array('action'=>'timecards')); ?> </li>
	</ul>
</div>
<?php //debug($this->data) 
?>
