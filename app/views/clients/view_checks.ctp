<?php echo $javascript->link('clients_view');?>

<div>
    <div>
        <?php echo $this->element('clients/menu', array('client'=>$this->data['Client'],)); ?>
    </div>
    <div class="client view" >
        <h3><?php echo $this->data['Client']['name']; ?>'s Checks</h3>


        <?php echo $this->element('client/address_info',array('client'=>$this->data['Client'],'webroot'=>$this->webroot)); ?>

        <!-- Checks -->
        <?php echo $html->link(__('New Check For Client', true), array('action'=>'add_check/'.$this->data['Client']['id'])); ?>
        <?php echo $html->link(__('Print View', true), array('action'=>'view_checks_print/'.$this->data['Client']['id'])); ?>
        <?php echo $this->element('client/list_checks', array(
                                            'checks'=>$this->data['ClientsCheck'],
                                            'next'=>$next,
                                            'webroot'=>$this->webroot, 'print'=>False,
                                            ));
                ?>
        <!-- Checks -->
        <?php echo $html->link(__('New Check For Client', true), array('action'=>'add_check/'.$this->data['Client']['id'])); ?>

    </div>
<div>