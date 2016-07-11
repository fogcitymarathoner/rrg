<div class="invoicesItems form">
<?php //debug($this->data); ?>
<?php echo $form->create('Reminders',array('action'=>'edit_item'));?>
	<fieldset>
 		<legend><?php __('Edit InvoicesItem - '.$this->data['Invoice']['ClientsContract']['title']);?></legend>
<?php echo $crumb->getHtml('Invoice Item Edit', null, 'auto' ) ;  
echo '<br /><br />' ;?>
	<?php
		echo $form->input('InvoicesItem.id',array('type'=>'hidden'));
		echo $form->input('InvoicesItem.invoice_id',array('type'=>'hidden'));
		echo $form->input('InvoicesItem.description', array('maxlength' => 60,'size' => 60,'class'=>'textInput'));
		echo $form->input('InvoicesItem.amount');
		echo $form->input('InvoicesItem.quantity');
		echo $form->input('InvoicesItem.cost');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Invoice', true), array('action'=>'edit/'.$form->value('InvoicesItem.invoice_id'))); ?> </li>
	</ul>
</div>
