<?php //debug($this->data);?>
<div class="clientsContracts form">


<?php echo $form->create('Employees',array('action'=>'manage_contract_emails'));?>
	<fieldset>
 		<legend><?php __("Manage Contract's Invoice Email Recipients");?></legend>
<h3><?php echo $this->data['ClientsContract']['title'].' -- '; ?></h3>
<?php echo $this->data['Employee']['firstname'].' '.$this->data['Employee']['lastname']; ?>
<?php echo $this->data['Client']['name']; ?>
	<?php
		echo $form->input('ClientsManager',array('name'=>'data[ClientsContract][ClientsManager]','type'=>'select','multiple'=>'checkbox','options' => $managersoptions));
		echo $form->input('User',array('name'=>'data[ClientsContract][User]','type'=>'select','multiple'=>'checkbox','options' => $usersoptions));
?>
<?php		
		echo $form->input('modified_user_id',array('name'=>'data[ClientsContract][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('id',array('name'=>'data[ClientsContract][id]','type'=>'hidden', 'value'=>$this->data['ClientsContract']['id']));
		echo $form->input('client_id',array('name'=>'data[ClientsContract][client_id]','type'=>'hidden', 'value'=>$this->data['ClientsContract']['client_id']));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<?php echo $client->contract_actions($this->data); ?>