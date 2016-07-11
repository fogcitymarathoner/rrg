<?php //debug($this->data);?>
<?php echo $html->link(__('Return to Employee', true), array('action'=>'view', $clientsContract['Employee']['id'])); ?>
<div class="clientsContracts form">
<?php echo $form->create('Employees',array('action'=>'edit_contract'));//debug($this->data['ClientsContract']);exit;?>
<?php echo $this->element('edit_clients_contract_form', array(
							'contract'=>$this->data['ClientsContract'],
							'employee'=>$this->data['Employee'],
							)); 
?>
<?php echo $form->end('Submit');?>
</div>
<?php echo $html->link(__('Return to Employee', true), array('action'=>'view', $clientsContract['Employee']['id'])); ?>