<?php echo $javascript->link('clients_view');?>
<?php echo $this->element('m/client_dialog_header',array('clientD'=>$this->data['Client']));?>
<h3><?php echo $this->data['Client']['name']; ?>'s Pastdue Invoices</h3>
<?php echo $client->view($this->data['Client'],$this->data['State']['name']); ?>
		
			 

<a href="<?php echo $this->webroot.'clients/view_invoices_pastdue_print/'.$this->data['Client']['id']?>" >View Printer Friendly Version</a>


<br>Report Time:<?php echo $runtime; ?>
	<!-- Invoices -->
	<?php echo $client->clients_contracts_invoices_pastdue_view($this->data['Invoice'],0,$next); ?>
	
	
