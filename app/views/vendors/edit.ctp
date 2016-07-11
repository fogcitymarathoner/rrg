<div class="vendors form">
<?php echo $form->create('Vendor'); ?>
	<fieldset>
 		<legend><?php __('Edit Vendor');?></legend>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Vendor', true), array('action'=>'view',$this->data['Vendor']['id']));?></li>
	</ul>
</div>
	<?php
		echo $form->input('id', array('type'=>'hidden'));
		echo $form->input('name');
		echo $form->input('purpose');
		echo $form->input('street1');
		echo $form->input('street2');
		echo $form->input('city');
		echo $form->input('state_id',array('label'=>'State'));
		echo $form->input('zip');
		echo $form->input('ssn');
		echo $form->input('apfirstname');
		echo $form->input('aplastname');
		echo $form->input('apemail');
		echo $form->input('apphone1');
		echo $form->input('apphone2');
		echo $form->input('accountnumber');
		echo $form->input('notes');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
