<div class="clientsSearches form">
<?php echo $form->create('Clients',array('action'=>'edit_search'));?>
	<fieldset>
 		<legend><?php __('Edit Search');?></legend>
	<?php
		echo $form->input('ClientsSearch.id',array('type'=>'hidden'));
		echo $form->input('ClientsSearch.client_id',array('type'=>'hidden'));
		echo $form->input('ClientsSearch.title');
		echo $form->input('ClientsSearch.description', array('maxlength' => 60,'size' => 60,'class'=>'textInput'));
		echo $form->input('ClientsSearch.notes', array('maxlength' => 60,'size' => 60,'class'=>'textInput'));
		echo $form->input('ClientsSearch.Resume',array('type'=>'select','multiple'=>'checkbox','options'=>$resumes));
		echo $form->input('ClientsSearch.modified_user_id',array('name'=>'data[ClientsSearch][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Client', true), array('action'=>'view_active_searches', $this->data['ClientsSearch']['client_id'])); ?> </li>
	</ul>
</div>