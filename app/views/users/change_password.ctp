<div class="users form">
<?php echo $form->create('User',array('action'=>'change_password'));?>
	<fieldset>
 		<legend><?php __('Change Password for user '.$this->data['User']['username']); ?></legend>
	<?php
		echo $form->input('id',array('hidden'=>'true'));
		echo $form->hidden('email', array( 'value' => $this->data['User']['email'] )); 
		echo $form->hidden('username', array( 'value' => $this->data['User']['username'] )); 
		echo $form->hidden('firstname', array( 'value' => $this->data['User']['firstname'] )); 
		echo $form->hidden('lastname', array( 'value' => $this->data['User']['lastname'] )); 
		echo $form->input('password',array('autocomplete'=>'off','value'=>''));
		echo $form->input('password_confirm',array('type'=>'password','autocomplete'=>'off'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
