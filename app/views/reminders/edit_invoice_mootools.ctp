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

<?php if($step == 1){ ?>

	<fieldset>
    <?php echo $this->element('edit_invoice_form', array(
            'ClientsContract'=>$this->data['ClientsContract'],
            ));
            ?>
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


<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Reminders', true), array('action'=>'timecards')); ?> </li>
	</ul>
</div>
<?php //debug($this->data) 
?>
