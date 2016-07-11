<?php echo $javascript->link('clients_view_contract');?>
<div class="clientsContracts view">
<?php echo $this->element('contract_menu',array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot,'controller'=>'clients')); ?>
<br>
    <?php echo $this->element('client/view_contract', array('ClientsContract'=>$this->data,)); ?>
    <?php echo $this->element('client/contract_actions', array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot)); ?>