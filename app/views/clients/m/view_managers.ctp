<?php echo $javascript->link('clients_view');?>
<?php echo $this->element('clients/menu', array('client'=>$this->data['Client'],)); ?>
<br>		
<br>		<h3><?php echo $this->data['Client']['name']; ?>'s Managers</h3>
<?php echo $client->view($this->data['Client'],$this->data['State']['name']); ?>
		

	<!-- Managers -->
	<?php echo $html->link(__('New Manager For Client', true), array('action'=>'add_manager/'.$this->data['Client']['id'])); ?>
	<?php echo $client->client_managers_view($this->data['ClientsManager']); ?>
	
