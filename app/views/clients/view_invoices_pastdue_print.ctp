
<h3><?php echo $client['name']; ?>'s Pastdue Invoices</h3>

<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
<br>Report Time:<?php echo $runtime; ?>

<!-- Invoices -->
<?php echo $this->element('client/past_due_invoices',array('invoices'=>$items,'print'=>1,'next'=>$next,'webroot'=>$this->webroot));?>