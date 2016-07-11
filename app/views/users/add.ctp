<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $form->input('username',array('autocomplete'=>'off'));
		echo $form->input('firstname',array('autocomplete'=>'off'));
		echo $form->input('lastname',array('autocomplete'=>'off'));
		echo $form->input('password',array('autocomplete'=>'off','value'=>''));
		echo $form->input('password_confirm',array('type'=>'password','autocomplete'=>'off'));
		echo $form->input('email',array('autocomplete'=>'off'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
