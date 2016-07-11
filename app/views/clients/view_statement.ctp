<?php echo $javascript->link('clients_view');?>
<?php echo $this->element('clients/menu', array('clientD'=>$client,)); ?>
        <br>
<h3><?php echo $client['name']; ?>'s Balance Statement</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
<a href="<?php echo $this->webroot.'clients/view_statement_print/'.$client['id']?>" >Print View</a>
<br>Report Time:<?php echo $runtime; ?>
<!-- Items -->
<?php echo $this->element('client/statement_view',array('items'=>$items,'next'=>$next,'print'=>0,'webroot'=>$this->webroot)); ?>
