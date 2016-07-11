<?php //debug($this->data);?>
<div class="clientsContracts form">
<?php echo $form->create('Clients',array('action'=>'edit_contract'));//debug($this->data);exit;?>


<?php echo $this->element('edit_clients_contract_form', array(
							'contract'=>$this->data['ClientsContract'],
							'employee'=>$this->data['Employee'],
							)); 
?>
	<?php echo $form->end('Submit');?>
</div>
<?php //echo $client->contract_actions($this->data); ?>