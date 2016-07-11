<?php echo $javascript->link('clients_view');?><h3><?php echo $client['name']; ?>'s Payment History</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>



<a href="<?php echo $this->webroot.'clients/view_payment_history/'.$this->data['Client']['id']?>" >Back</a>

<br>Report Time:<?php echo $runtime; ?>
	<!-- Items -->
<?php echo $this->element('clients/payment_history',array('webroot'=>$this->webroot,'items'=>$items,'print'=>1 ));?>
	
	
