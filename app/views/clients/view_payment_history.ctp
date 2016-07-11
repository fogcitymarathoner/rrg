<?php echo $javascript->link('clients_view');?>
<?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
?>

<br>		
<br>		<h3><?php echo $client['name']; ?>'s Payment History</h3>
<div>
    Data from file <?php echo $fixfile?>
</div>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
		

    <a href="<?php echo $this->webroot.'clients/view_payment_history_print/'.$this->data['Client']['id']?>" >View Printer Friendly Version</a>

<br>Report Time:<?php echo $runtime; ?>
	<!-- Items -->
	<?php echo $this->element('clients/payment_history',array('webroot'=>$this->webroot,'items'=>$items,'print'=>0 ));?>
	
	
