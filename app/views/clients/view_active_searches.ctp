<?php echo $javascript->link('clients_view');?>

<?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
<br>		
<br>		<h3><?php echo $client['name']; ?>'s Active Searches</h3>
<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
		

<!-- Active Searches -->
<?php echo $html->link(__('New Search For Client', true), array('action'=>'add_search/'.$this->data['Client']['id'])); ?>
<?php echo $this->element('client/searches',array('searches'=>$this->data['ClientsSearch'],'state_id'=>1,'webroot'=>$this->webroot)); ?>
