<div class="clientsSearches form">
<?php echo $form->create('Clients',array('action'=>'add_search'));?>
	<fieldset>
 		<legend><?php __('Add Search');?></legend>
	<?php
		echo $form->input('ClientsSearch.title');
		echo $form->input('ClientsSearch.description', array('maxlength' => 60,'size' => 60,'class'=>'textInput'));
		echo $form->input('ClientsSearch.notes', array('maxlength' => 60,'size' => 60,'class'=>'textInput'));

		echo $form->input('ClientsSearch.Resume',array('type'=>'select','options'=> $resumes, 'multiple'=>'checkbox'));
		echo $form->input('ClientsSearch.client_id',array('type'=>'hidden','value'=>$this->data['ClientsSearch']['client_id']));
		echo $form->input('modified_user_id',array('name'=>'data[ClientsSearch][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('name'=>'data[ClientsSearch][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Client', true), array('action'=>'view_active_searches', $this->data['ClientsSearch']['client_id'])); ?> </li>
	</ul>
</div>
