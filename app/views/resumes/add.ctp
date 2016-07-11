<div class="resumes form">
<?php echo $form->create('Resume');?>
	<fieldset>
 		<legend><?php __('Add Resume');?>|<?php echo $html->link(__('Return to Resume List', true), array('action'=>'index')); ?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('active',array('value'=>1,'type'=>'hidden'));
		$this->data['Resume']['resume'] = '';
		echo $fck->fckeditor(array('Resume', 'resume'), $html->base, $this->data['Resume']['resume']); 
		echo $form->input('notes');
		echo $form->input('ClientsSearch');
		echo $form->input('modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('type'=>'hidden', 'value'=>$currentUser));		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Resumes', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List States', true), array('controller'=> 'states', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New State', true), array('controller'=> 'states', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Clients Searches', true), array('controller'=> 'clients_searches', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Clients Search', true), array('controller'=> 'clients_searches', 'action'=>'add')); ?> </li>
	</ul>
</div>