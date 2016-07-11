<?php echo $javascript->link('clients_view');?>
<?php echo $this->element('clients/menu', array('client'=>$client,'webroot'=>$this->webroot,)); ?>
<br>		
<br>		<h3><?php echo $client['name']; ?>'s Posted Open Invoices</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
<a href="<?php echo $this->webroot.'clients/view_invoices_print/'.$client['id']?>" >View Printer Friendly Version</a>
<!-- Invoices -->
<?php echo $html->link(__('New Invoice For Client', true), array('action'=>'add_invoice/'.$client['id'])); ?>
<?php if (!empty($this->data['Invoice']))
{
    echo $this->element('client_contract_invoices',$this->data['Invoice'],$next,0);
}
?>

<br>Report Time:<?php echo $runtime; ?>
<!-- Items -->
<?php echo $this->element('client/open_invoices',array('items'=>$items,'next'=>$next,'print'=>0,'webroot'=>$this->webroot)); ?>
