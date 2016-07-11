<?php echo $javascript->link('clients_view');?>
<h3><?php echo $this->data['Client']['name']; ?>'s Checks</h3>

<?php echo $this->element('client/address_info',array('client'=>$this->data['Client'],'webroot'=>$this->webroot)); ?>
	<!-- Checks -->
	<?php echo $this->element('client/list_checks', array(
							'checks'=>$this->data['ClientsCheck'],
							'next'=>$next,
							'webroot'=>$this->webroot, 'print'=>True,
							)); 
?>	
