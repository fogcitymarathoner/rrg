<div class="clientseditinvoice form">


	<fieldset>
<?php 
//debug($this->data['ClientsContract']);exit;
echo $form->create('Reminders',array('action'=>'edit_notes/','name'=>'invoice_form'));?>
	<fieldset>
 		<legend><?php __('Edit Reminder Notes');?></legend>
		<?php
		echo '<h3>'.$this->data['Employee']['Employee']['firstname'].' '.$this->data['Employee']['Employee']['lastname'].'</h3>';
		echo '<h3>'.$this->data['Client']['Client']['name'].'</h3>';

		?>

      
      <?php
      
		echo $form->input('Invoice.period_start',array('READONLY'=>TRUE)); 
		echo $form->input('Invoice.period_end',array('READONLY'=>TRUE)); 
		echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>100));
		echo $form->input('Invoice.next',array('type'=>'hidden', 'value'=>$next));
		echo $form->input('Invoice.id',array('type'=>'hidden'));
		?> 

		</table>
		  
	<?php	echo $form->end('Submit');?>		
	</fieldset>


<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Reminders', true), array('action'=>$next)); ?> </li>
	</ul>
</div>
