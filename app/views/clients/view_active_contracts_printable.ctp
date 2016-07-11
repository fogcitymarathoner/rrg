<?php echo $javascript->link('clients_view');?>
<h3><?php echo $page_title; ?></h3>
<?php echo $this->element('client/address_info',array('client'=>$this->data['Client'],'webroot'=>$this->webroot)); ?>
<?php echo $this->element('contracts_index_report', array('contracts'=>$contracts['ClientsContract'],'next'=>$next,'active'=>$active,'webroot'=>$this->webroot,));?>