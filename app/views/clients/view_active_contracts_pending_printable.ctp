<?php echo $javascript->link('clients_view');?>

<br>		
<br>		<h3><?php echo $page_title; ?></h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
	<!-- Active Pending Contracts -->
<?php echo $this->element('contracts_index_pending_report', array(
							'contracts'=>$contracts['ClientsContract'],
							'contracts'=>$contracts['ClientsContract'],
							'next'=>$next,
							'active'=>$active,
							'webroot'=>$this->webroot,
							)); 
?>
