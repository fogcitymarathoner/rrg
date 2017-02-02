<?php echo $javascript->link('clients_view');?>

<?php echo $this->element('clients/menu', array('clientD'=>$this->data['Client'],)); ?>
<br>		
<br>		<h3><?php echo $this->data['Client']['name']; ?>'s Opening Commissions Invoices</h3>
<?php echo $client->view($this->data['Client'],$this->data['State']['name']); ?>
		

    <a href="<?php echo $this->webroot.'clients/view_invoices_print/'.$this->data['Client']['id']?>" >View Printer Friendly Version</a>

	<!-- Invoices -->
	<?php echo $client->clients_contracts_invoices_view($this->data['Invoice'],$next,0); ?>
	
	
