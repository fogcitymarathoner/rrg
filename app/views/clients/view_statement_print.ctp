<?php echo $javascript->link('clients_view');?>
<h3><?php echo $client['name']; ?>'s Balance Statement</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
<a href="<?php echo $this->webroot.'clients/view_statement/'.$client['id']?>" >Back</a>
<br>Report Time:<?php echo $runtime; ?>
	<!-- Items -->
	<?php echo $this->element('client/statement_view',array('items'=>$items,'next'=>$next,'print'=>1,'webroot'=>$this->webroot)); ?>
