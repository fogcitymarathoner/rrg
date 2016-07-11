<div class="clients form">
<?php 
//debug($this->data);
	echo $form->create('Client');?>
	<fieldset>
 		<legend><?php __('Edit Client');?></legend>
	<?php
		echo $form->input('id',array('type'=>'hidden'));
		echo $form->input('name',array('size'=>40));
		echo $form->input('street1');
		echo $form->input('street2');
		echo $form->input('city');
		echo $form->input('state_id');
		echo $form->input('zip');
		echo $form->input('terms');
		echo $form->input('active',array('options'=>$activeOptions));
		echo $form->input('modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return', true), array('action'=>'view',$this->data['Client']['id']));?></li>
	</ul>
</div>
