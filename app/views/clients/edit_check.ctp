If the list of invoices credited to check is different, delete and reenter the check.
If the values are different, edit check credit values in the check view.
<?php
echo $form->create('ClientsCheck',array('url' => array('controller'=>'clients','action'=>'edit_check/'))); ?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
 		<table>
	<?php
		echo $form->input('id', array('type'=>'hidden','value'=>$this->data['ClientsCheck']['id']));
		echo $form->input('client_id', array('type'=>'hidden','value'=>$clientData['Client']['id']));
		echo '<tr><td>';
		echo $form->input('number', array('size'=>12,'value'=>$this->data['ClientsCheck']['number']));
		echo '</td></tr><tr>';
		echo '<td>';
$dateexplode = explode('-',$this->data['ClientsCheck']['date']);
$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; 
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
		echo $form->input('notes', array('size'=>70,'value'=>$this->data['ClientsCheck']['notes']));
		echo $form->input('next',array('type'=>'hidden','value'=>$next));
		echo '</td>';
		echo '</tr>';
		?>
		</table>

	</fieldset>
<?php echo $form->end('Submit'); ?>

<div class="related">
	<h3><?php __('Payments');
	?></h3>
	<?php if (!empty($clientsCheck['InvoicesPayment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Invoice No.'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($clientsCheck['InvoicesPayment'] as $invoicesPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $invoicesPayment['invoice_id'];?></td>
			<td><?php echo sprintf('%8.2f',round($invoicesPayment['amount'],2));?></td>
			<td><?php echo $invoicesPayment['Invoice']['notes'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
