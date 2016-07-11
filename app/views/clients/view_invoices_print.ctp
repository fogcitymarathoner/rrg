<?php echo $javascript->link('clients_view');?>
<h3><?php echo $client['name']; ?>'s Posted Open Invoices</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
<?php if (!empty($this->data['Invoice']))
{
    echo $this->element('client_contract_invoices',$this->data['Invoice'],$next,0);
}
?>

<br>Report Time:<?php echo $runtime; ?>
<!-- Items -->
<?php echo $this->element('client/open_invoices',array('items'=>$items,'next'=>$next,'print'=>1,'webroot'=>$this->webroot)); ?>
