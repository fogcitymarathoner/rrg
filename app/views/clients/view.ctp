<?php echo $javascript->link('clients_view');?>

<div>
    <div>
        <?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
    </div>
    <div class="client view" >
        <h3><?php echo $this->data['Client']['name']; ?>'s General Info</h3>


        <?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>

        <!-- Checks -->
        <?php echo $html->link(__('New Check For Client', true), array('action'=>'add_check/'.$this->data['Client']['id'])); ?>
        <h3><a href="http://maps.google.com/?q=<?php echo $client['street1']; ?>+
        <?php echo $client['city']; ?>+<?php echo $client['state']; ?>+
        <?php echo $client['zip']; ?>">MAP</a></h3>

    </div>
<div>