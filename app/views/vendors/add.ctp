<div class="vendors form">
<?php echo $form->create('Vendor');?>
	<fieldset>
 		<legend><?php __('Add Vendor');?></legend>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Vendor Search', true), array('action'=>'search'));?></li>
	</ul>
</div>
 		
	<?php
		echo $form->input('name');
		echo $form->input('purpose');
		echo $form->input('street1');
		echo $form->input('street2');
		echo $form->input('city');
		echo $form->input('state_id',array('value'=>5,'label'=>'State'));
		echo $form->input('zip');
		echo $form->input('ssn');
		echo $form->input('apfirstname',array('label'=>'First Name'));
		echo $form->input('aplastname',array('label'=>'Last Name'));
		echo $form->input('apemail');
		echo $form->input('apphonetype1');
		echo $form->input('apphone1');
		echo $form->input('apphonetype2');
		echo $form->input('apphone2');
		echo $form->input('accountnumber');
		echo $form->input('notes'); ?>
<option value="1">INACTIVE</option>
<option value="2" selected="selected">ACTIVE</option>
</select></div>	
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
