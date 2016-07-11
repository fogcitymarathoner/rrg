<div class="clientsManagers form">
<?php echo $form->create('Clients',array('action'=>'edit_manager'));?>
	<fieldset>
 		<legend><?php __('Edit ClientsManager');?></legend>
	<?php
		echo $form->input('id',array('name'=>'data[ClientsManager][id]','value'=>$this->data['ClientsManager']['id'],'type'=>'hidden'));
		echo $form->input('client_id',array('name'=>'data[ClientsManager][client_id]','value'=>$this->data['ClientsManager']['client_id'],'type'=>'hidden'));
		echo $form->input('firstname',array('name'=>'data[ClientsManager][firstname]','value'=>$this->data['ClientsManager']['firstname']));
		echo $form->input('lastname',array('name'=>'data[ClientsManager][lastname]','value'=>$this->data['ClientsManager']['lastname']));
		echo $form->input('title',array('name'=>'data[ClientsManager][title]','value'=>$this->data['ClientsManager']['title']));
		echo $form->input('email',array('name'=>'data[ClientsManager][email]','value'=>$this->data['ClientsManager']['email']));
		echo $form->input('phone1',array('name'=>'data[ClientsManager][phone1]','value'=>$this->data['ClientsManager']['phone1']));
		echo $form->input('phone2',array('name'=>'data[ClientsManager][phone2]','value'=>$this->data['ClientsManager']['phone2']));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('RETURN', true), array('controller'=>'clients','action'=>'view_managers', $this->data['ClientsManager']['client_id'])); ?> </li>
	</ul>
</div>
