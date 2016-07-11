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

	<fieldset>
<?php echo $form->create('Clients',array('action'=>'edit_mock_invoice','name'=>'invoice_form'));?>
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
				echo sprintf('%8.2f',round($item['InvoicesItem']['cost'],2));
				echo '<br>';
				echo sprintf('%8.2f',round($item['InvoicesItem']['amount'],2));
				echo '<br>';
				if(!empty($item['InvoicesItemsCommissionsItem']))
				{
					foreach($item['InvoicesItemsCommissionsItem'] as $citem)
					{
                //debug($citem);
                //debug($employees);
						echo $employees[$citem['employee_id']];
						echo sprintf('%8.2f',round($citem['amount'],2));
						echo '<br>';
					}
				}
			}
		}
	}
		
		$dateexplode = explode('-',$this->data['Invoice']['date']);
		$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; 
		?>
<p><label for="invoice_date">Date</label> : <input type="text" class="w16em" id="date" name="data[Invoice][date]" value="<?php echo $javadate; ?>" /></p>
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
		echo $form->input('Invoice.id',
				array('type'=>'hidden'));
		echo $form->input('Invoice.voided',
				array('value'=>1, 'type'=>'hidden'));
		echo $form->input('Invoice.contract_id',
				array('type'=>'hidden'));
		echo $form->input('Invoice.employerexpenserate'); 
		echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>100));
		echo $form->input('ClientsContract.invoicemessage',array('rows'=> 5, 'cols'=>80,'disabled' => "disabled", 
				'label'=>'Invoice Message From Contract',
				'value'=> $this->data['ClientsContract']['invoicemessage']));
		echo $form->input('Invoice.message',array('rows'=> 10, 'cols'=>80));
		
		echo $form->input('Invoice.period_start'); 
		echo $form->input('Invoice.period_end'); 

		echo $form->input('Invoice.modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
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
				<input type="text" name="data[Item][<?php echo $i; ?>][cost]" value=<?php echo sprintf('%8.2f',round($invoicesItem['cost'],2)?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input id="amount" type="text" name="data[Item][<?php echo $i; ?>][amount]" value=<?php echo sprintf('%8.2f',round($invoicesItem['amount'],2))?>  AUTOCOMPLETE="OFF"/>
				</td>
	
				<td>
				<input id="quantity" type="text" name="data[Item][<?php echo $i; ?>][quantity]" value=<?php echo $invoicesItem['quantity']?>  AUTOCOMPLETE="OFF"/>
				</td>			
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][subtotal]" value=<?php echo sprintf('%8.2f',round($invoicesItem['quantity']*$invoicesItem['amount'],2))?>  AUTOCOMPLETE="OFF"/>
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
				<input type="text" name="grandtotal" value=<?php echo sprintf('%8.2f',round($this->data['Invoice']['amount'],2));?>  AUTOCOMPLETE="OFF"/>
				</td>	
				<td>
				</td>		
			</tr>
		</table>
<?php endif; ?>
		  
	<?php	echo $form->end('Submit');?>		
	</fieldset>
<?php echo $html->link(__('Rebuild', true), array('action'=>'rebuild_mock_invoice', $this->data['Invoice']['id'])); ?>

</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Mock Invoice Manage', true), array('action'=>'view_mock_invoice', $this->data['Invoice']['id'])); ?> </li>
	</ul>
	
<?php echo $client->contract_actions($clientsContract); ?>
</div>
<?php 
//debug($this->data) ;
// This exit prevents a blank screen!!
exit;
?>


