<div class="users form">
<?php echo $form->create('User'); ?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('id',array('hidden'=>'true'));
		echo $form->input('username',array('autocomplete'=>'off'));
		echo $form->input('firstname',array('autocomplete'=>'off'));
		echo $form->input('lastname',array('autocomplete'=>'off'));
		echo $form->input('email',array('autocomplete'=>'off'));
		echo $form->hidden('password', array( 'value' => $this->data['User']['password'] )); 
		echo $form->hidden('password_confirm', array( 'value' => $this->data['User']['password'] )); 
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
