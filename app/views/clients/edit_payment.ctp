<div class="invoicesPayments form">
<?php 
//debug($this->data);

echo $form->create('InvoicesPayment');?>
	<fieldset>
 		<legend><?php __('Edit InvoicesPayment for invoice: '.$this->data['Invoice']['id']);?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('invoice_id', array('type'=>'hidden'));
		echo $form->input('amount');
		echo $form->input('notes');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('return to invoice', true), array('controller'=>'invoices','action'=>'view', $this->data['Invoice']['id'])); ?> </li>
	</ul>
</div>
