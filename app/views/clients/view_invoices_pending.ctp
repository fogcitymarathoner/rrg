<?php echo $javascript->link('clients_view');?>

<?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
<br>		
<br>		<h3><?php echo $client['name']; ?>'s Pending Invoices</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>


	<!-- Invoices -->
	<?php echo $html->link(__('New Invoice For Client', true), array('action'=>'add_invoice/'.$this->data['Client']['id'])); ?>
	<?php echo $this->element('client/pending_invoices',array('invoices'=>$this->data['Invoice'],'next'=>$next,'webroot'=>$this->webroot)); ?>
	
	
