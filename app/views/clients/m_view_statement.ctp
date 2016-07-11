<?php echo $javascript->link('clients_view');?>
<?php echo $this->element('m/client_dialog_header',array('clientD'=>$clientD));?>
<h3><?php echo $clientD['name']; ?>'s Balance Statement</h3>
<?php echo $client->view($clientD,$state); ?>
		

    <a href="<?php echo $this->webroot.'clients/view_statement_print/'.$this->data['Client']['id']?>" >View Printer Friendly Version</a>

<br>Report Time:<?php echo $runtime; ?>
	<!-- Items -->
	<?php echo $client->client_statement_view($items,$next,0); ?>
	
	
