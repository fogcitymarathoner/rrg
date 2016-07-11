<?php echo $javascript->link('clients_view');


?>

<br>		
<br>		<h3><?php echo $page_title; ?></h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
	<!-- Active Contracts -->

<?php echo $this->element('contracts_index_report_ytd', array('contracts'=>$this->data['ClientsContract'],'next'=>$next,'active'=>$active,'webroot'=>$this->webroot,)); ?>
