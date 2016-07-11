<?php echo $javascript->link('clients_view');?>

<?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
<br>		
<br>		<h3><?php echo $client['name']; ?>'s Memos</h3>

<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>

<!-- Memos -->
<?php echo $html->link(__('New Memo For Client', true), array('action'=>'add_memo/'.$client['id'])); ?>
<?php echo $this->element('client/memos',array('memos'=> $this->data['ClientsMemo'], 'webroot'=>$this->webroot)); ?>
