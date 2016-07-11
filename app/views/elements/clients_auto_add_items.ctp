
<?php echo $form->create('Clients',array('action'=>'auto_add_items','id'=>'autoadd_contract_items'));?>

<fieldset>
    <legend><?php __('Method One: Enter the base hourly wage (Assumes 35% markup)');?></legend>
    <?php
            echo $form->input('ContractsItem.contract_id',array('type'=>'hidden','value'=>$clientsContract['ClientsContract']['id']));

            echo $form->input('ContractsItem.method',array('type'=>'hidden','value'=>1));
            echo $form->input('ContractsItem.cost', array('label' => 'Wage Paid to Worker'));
            ?>
</fieldset>
        <?php echo $form->end('AutoAddItems');?>

        <?php echo $form->create('Clients',array('action'=>'auto_add_items','id'=>'autoadd_contract_items','method'=>2));?>

<fieldset>
<legend><?php __('Method Two: Enter the hourly wage AND billout');?></legend>
<?php
        echo $form->input('ContractsItem.contract_id',array('type'=>'hidden','value'=>$clientsContract['ClientsContract']['id']));

        echo $form->input('ContractsItem.method',array('type'=>'hidden','value'=>2));
        echo $form->input('ContractsItem.cost', array('label' => 'Wage Paid to Worker'));
        echo $form->input('ContractsItem.amount', array('label' => 'Bill Out Paid by Client'));
        ?>
</fieldset>
        <?php echo $form->end('AutoAddItems');?>