<?php echo $javascript->link('clients_view');?>
<?php echo $client->view($this->data['Client'],$state); ?>

<div data-role="content">
    <ul data-role="listview">
        <li>
        <h3><?php echo $this->data['Client']['name']; ?>'s Pending Invoices</h3>
<?php echo $client->view($this->data['Client'],$state); ?>
		

	<!-- Invoices -->
	<?php echo $client->m_clients_contracts_pending_invoices_view($this->data['Invoice'],$next); ?>
	
	    </li>
    </ul>
</div>
