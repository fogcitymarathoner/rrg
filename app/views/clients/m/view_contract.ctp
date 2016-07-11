<?php echo $this->element('m/client_contract_dialog_header',array('clientD'=>$clientD['Client']));?>
<div data-role="content">
    <ul data-role="listview">
        <li>
            <?php echo $this->element('m/view_clients_contract', array('ClientsContract'=>$this->data,)); ?>
        </li>
    </ul>
</div>