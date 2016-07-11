<?php //debug($step);?>
<script language="javascript" type="text/javascript" >
<!-- hide

function jumpto(x){
if (document.form1.jumpmenu.value != "null" && document.form1.jumpmenu.value != 'Select Contract') {
document.location.href = x
}
}
// end hide -->
</script>
<div class="employeesPayments form">
<?php if($step == 1){  ?>
	<fieldset>
 		<legend><?php __('Select Contract');?></legend>
<form name="form1">
<select name="jumpmenu" onChange="jumpto(document.form1.jumpmenu.options[document.form1.jumpmenu.options.selectedIndex].value)">
<option>Select Contract</option>
<?php  
$keys = array_keys($contractsMenu);
foreach($keys as $key) {
	echo "<option value='./".$client_id.'/2/'.$key.
				"'>".$contractsMenu[$key].'</option>';
}
?>
</select>
</form>
	</fieldset>
<?php } ?>



<?php if($step == 2){ ?>
<script type="text/javascript">

  function MyCalc(){ 
    var rows = document.getElementById('invTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    var total = 0;
    for (i = 1; i < rows.length-1; i++) {

  		document.invoice_form["data[Item]["+i+"][subtotal]"].value = 
  											Math.round(parseFloat(document.invoice_form["data[Item]["+i+"][amt]"].value *
  												document.invoice_form["data[Item]["+i+"][quantity]"].value*100))/100;
  		total = total + parseFloat(document.invoice_form["data[Item]["+i+"][subtotal]"].value);
    }
	document.invoice_form["grandtotal"].value = total;
  }
</script>
<table id="atable">
</table>
<?php echo $form->create('Clients',array('action'=>'add_invoice/'.$client_id.'/3','name'=>'invoice_form'));?>
	<fieldset>
 		<legend><?php __('Add Invoice');?></legend>
		<?php
		echo '<h3>'.$contract['Employee']['firstname'].' '.$contract['Employee']['lastname'].'</h3>';
		echo $form->input('contract_id',
				array('type'=>'hidden'));
		//echo $form->input('date',array('value'=>date('Y-m-d')));
		
		$this->data['Invoice']['date'] = date('Y-m-d');
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
		echo $form->input('Invoice.po',array('value'=>$contract['ClientsContract']['po'],'AUTOCOMPLETE'=>'OFF'));
		echo $form->input('Invoice.employerexpenserate',
				array('value'=>$contract['ClientsContract']['employerexp'],'AUTOCOMPLETE'=>'OFF'));
		echo $form->input('Invoice.terms',array('value'=>$contract['ClientsContract']['terms'],'AUTOCOMPLETE'=>'OFF'));
		echo $form->input('Invoice.timecard',
				array('type'=>'hidden','value'=>1));
		echo $form->input('Invoice.posted',
				array('type'=>'hidden','value'=>0));
		echo $form->input('Invoice.cleared',
				array('type'=>'hidden','value'=>0));
		echo $form->input('Invoice.voided',
				array('type'=>'hidden','value'=>0)); 
		echo $form->input('Invoice.contract_id',
				array('type'=>'hidden','value'=>$contract['ClientsContract']['id']));
		echo $form->input('Invoice.client_id',
				array('type'=>'hidden','value'=>$client_id));
		echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>100));
		echo $form->input('ClientsContract.invoicemessage',array('rows'=> 5, 'cols'=>80,'disabled' => "disabled", 
				'label'=>'Invoice Message From Contract',
				'value'=> $contract['ClientsContract']['invoicemessage']));
		echo $form->input('Invoice.message',
				array('value'=>'Please forward to your accounts payable department with the commentary, "APPROVED." Thank you for your business.',
				 'AUTOCOMPLETE'=>'OFF','rows'=>10, 'cols'=>60));
		echo $form->input('Invoice.period_id',array('options'=>$periodpicker, 'AUTOCOMPLETE'=>'OFF', 'value'=>$currentperiod));

		echo $form->input('Invoice.modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('Invoice.created_user_id',array('type'=>'hidden', 'value'=>$currentUser));   
		?> 
		<div class="related">
	<h3><?php __('Line Items');?></h3>
	<?php if (!empty($contract['ContractsItem'])):?>
	<table cellpadding = "0" cellspacing = "0" id="invTable">
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Subtotal'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contract['ContractsItem'] as $invoicesItem):
			if($invoicesItem['active'])
			{
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo 'Item:'.$i;?>
				<input type="hidden" name="data[Item][<?php echo $i; ?>][id]"  value=<?php echo $invoicesItem['id']?> />
				<input type="text" name="data[Item][<?php echo $i; ?>][description]"  value=<?php echo $invoicesItem['description']?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][cost]" value=<?php echo sprintf('%8.2f',round($invoicesItem['cost'],2)); ?>  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input id="amount" type="text" name="data[Item][<?php echo $i; ?>][amt]" value=<?php echo $invoicesItem['amt']?>  AUTOCOMPLETE="OFF"/>
				</td>
	
				<td>
				<input id="quantity" type="text" name="data[Item][<?php echo $i; ?>][quantity]" value=0  AUTOCOMPLETE="OFF"/>
				</td>			
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][subtotal]" value=0  AUTOCOMPLETE="OFF"/>
				</td>			
			</tr>
	<?php }// active inactive decision ?>
		<?php endforeach; ?>
			<tr<?php echo $class;?>>
				<td><?php echo 'Item:'.++$i;?>
				<input type="hidden" name="data[Item][<?php echo $i; ?>][id]"  value="99999" />
				<input type="text" name="data[Item][<?php echo $i; ?>][description]"  value="Miscellaneous"  AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][cost]"   AUTOCOMPLETE="OFF"/>
				</td>
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][amt]"  AUTOCOMPLETE="OFF"/>
				</td>
	
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][quantity]" value=0  AUTOCOMPLETE="OFF"/>
				</td>			
				<td>
				<input type="text" name="data[Item][<?php echo $i; ?>][subtotal]" value=0  AUTOCOMPLETE="OFF"/>
				</td>			
			</tr>			<tr<?php echo $class;?>>
				<td>
				</td>
				<td>
				</td>
				<td><input type="button" name="btnCalc" value="Recalculate" onclick="MyCalc()">
				</td>
				<td align="right">Total:
				</td>
				<td align="right">
				<input type="text" name="grandtotal" value=0  AUTOCOMPLETE="OFF"/>
				</td>			
			</tr>
		</table>
<?php endif; ?>



</div>
		  
	<?php	echo $form->end('Submit');?>		
	</fieldset>
	
<?php echo $html->link(__('Rebuild', true), array('action'=>'add_invoice', $contract['ClientsContract']['client_id'],2,$contract['ClientsContract']['id'])); ?>
	
<?php //debug($contract);
} ?>

<?php if($step == 3){ ?>
STEP 3
Client <?php echo $this->data['Client']['Client']['name'];?><br>
Employee <?php echo $this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'];?><br>
Period <?php echo date("m/d/Y",strtotime($this->data['Invoice']['period_start'])).'-'.date("m/d/Y",strtotime($this->data['Invoice']['period_end']));?><br>
Amount <?php echo sprintf('%8.2f',round($this->data['Invoice']['amount'],2));?><br>

<?php echo $html->link(__('Preview', true), array('action'=>'view_invoice_pdf', $this->data['Invoice']['id'])); ?>
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
				echo sprintf('%8.2f',round($item['InvoicesItem']['cost'],2));
				echo '<br>';
				echo sprintf('%8.2f',round($item['InvoicesItem']['amount'],2));
				echo '<br>';
				if(!empty($item['InvoicesItemsCommissionsItem']))
				{
					foreach($item['InvoicesItemsCommissionsItem'] as $citem)
					{
						echo $employees[$citem['employee_id']]; 
						echo sprintf('%8.2f',round($citem['amount'],2));
						echo '<br>';
					}
				}
			}
		}
	}
?>
<?php }; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Client', true), array('action'=>'view_invoices_pending', $client_id)); ?> </li>
	</ul>
</div>

<?php 
//debug($this->data) ;
// This exit prevents a blank screen!!
//exit;
?>
