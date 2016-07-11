<div class="clients form">
<?php echo $form->create('Client');?>
	<fieldset>
 		<legend><?php __('Add Client');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('street1');
		echo $form->input('street2');
		echo $form->input('city');
		echo $form->input('state_id',array('value'=>5));
		echo $form->input('zip');
		echo $form->input('terms',array('value'=>30));
		echo $form->input('modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('type'=>'hidden', 'value'=>$currentUser));		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return', true), array('action'=>'index'));?></li>
	</ul>
</div>
