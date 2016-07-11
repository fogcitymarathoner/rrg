<div class="resumes form">
<?php echo $form->create('Resume'); //debug($this->viewVars); ?>
	<fieldset>
 		<legend><?php __('Edit Resume');?></legend>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Resume List', true), array('action'=>'index'));?></li>
	</ul>
</div>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('email');
		echo $form->input('phone');
		echo $fck->fckeditor(array('Resume', 'resume'), $html->base, $this->data['Resume']['resume']); 
		echo $form->input('notes');
		echo $form->input('active',array('options'=>$activeOptions));
		echo $form->input('modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('ClientsSearch');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Resume List', true), array('action'=>'index'));?></li>
	</ul>
</div>
