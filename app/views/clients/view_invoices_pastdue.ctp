<?php echo $javascript->link('clients_view');?>
<div>
    <div>
        <?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
    </div>
    <div class="client view" >
        <h3><?php echo $client['name']; ?>'s Pastdue Invoices</h3>
        <div>
            <?php echo 'Data from: '.$fixfile ?>
        </div>
        <?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>


        <a href="<?php echo $this->webroot.'clients/view_invoices_pastdue_print/'.$client['id']?>" >View Printer Friendly Version</a>

        <br>Report Time:<?php echo $runtime; ?>

            <!-- Invoices -->
        <?php echo $this->element('client/past_due_invoices',array('invoices'=>$items,'print'=>0,'next'=>$next,'webroot'=>$this->webroot,));?>
    </div>
<div>