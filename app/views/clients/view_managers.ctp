<?php
    echo $javascript->link('clients_view');
    echo $this->element('clients/menu', array('client'=>$client,));
?>
<br>		
<br>		<h3><?php echo $client['name']; ?>'s Managers</h3>

<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>

	<!-- Managers -->
	<?php echo $html->link(__('New Manager For Client', true), array('action'=>'add_manager/'.$client['id'])); ?>
	<?php echo $this->element('client/managers', array('managers'=>$this->data['ClientsManager'],'webroot'=>$this->webroot)); ?>
	
