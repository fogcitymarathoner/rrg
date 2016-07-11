<?php echo $javascript->link('clients_view');
        //debug($clientdata);
        ?>

<?php echo $this->element('clients/menu', array('client'=>$client,)); ?>
<br>		
<br>		<h3><?php echo $page_title; ?></h3>

<?php echo $this->element('client/address_info',array('client'=>$client,'webroot'=>$this->webroot)); ?>
	<!-- Inactive Contracts -->
	<?php //echo $html->link(__('New Contract For Client', true), array('action'=>'add_contract/'.$clientdata['Client']['id'])); ?>
<?php
        /*
        echo $this->element('contracts_index', array(
							'contracts'=>$this->data['ClientsContract'],
							'next'=>$next,
							'active'=>$active,
							'webroot'=>$this->webroot,
							));
        */
?>
    <?php

        function js_active_inactive($clientsContract,$webroot)
        {
            $res = '<form name=xx autocomplete="off" class="user_data_form">';
            if ($clientsContract['active'] == 0)
            {
                $res .= '<input type="radio" name="contract_activeinactive_'.$clientsContract['id'].'" onClick="contract_activeinactive(\'Up\','.$clientsContract['id'].',\''.$webroot.'\')" value="Active"> Active
                <input type="radio" name="contract_activeinactive_'.$clientsContract['id'].'" onClick="contract_activeinactive(\'Down\','.$clientsContract['id'].',\''.$webroot.'\')"
                value="Inactive" checked> Inactive';
            } else {
                $res .= '<input type="radio" name="contract_activeinactive_'.$clientsContract['id'].'" onClick="contract_activeinactive(\'Up\','.$clientsContract['id'].',\''.$webroot.'\')"
                value="Willing" checked> Active
                <input type="radio" name="contract_activeinactive_'.$clientsContract['id'].'" onClick="contract_activeinactive(\'Down\','.$clientsContract['id'].',\''.$webroot.'\')"
                value="Inactive"> Inactive';
            }
            $res .= '</form>';

            return $res;
        }

        function js_addendum($clientsContract,$webroot)
        {
            $res = '<form name=xx autocomplete="off" class="user_data_form">';
            if ($clientsContract['addendum_executed'] == 0)
            {
                $res .= '<input type="radio" name="contract_addendum_'.$clientsContract['id'].'" onClick="contract_addendum(\'Up\','.$clientsContract['id'].',\''.$webroot.'\')" value="Active"> Inplace
                <input type="radio" name="contract_activeinactive_'.$clientsContract['id'].'" onClick="contract_addendum(\'Down\','.$clientsContract['id'].',\''.$webroot.'\')"
                value="Inactive" checked> Pending';
            } else {
                $res .= '<input type="radio" name="contract_addendum_'.$clientsContract['id'].'" onClick="contract_addendum(\'Up\','.$clientsContract['id'].',\''.$webroot.'\')"
                value="Willing" checked> Inplace
                <input type="radio" name="contract_addendum_'.$clientsContract['id'].'" onClick="contract_addendum(\'Down\','.$clientsContract['id'].',\''.$webroot.'\')"
                value="Inactive"> Pending';
            }
            $res .= '</form>';

            return $res;
        }
    ?>
    <table cellpadding = "3" cellspacing = "3" border=1>
    <?php
                $i =0;
                foreach ($this->data['ClientsContract'] as $clientsContract):
            //debug($clientsContract);exit;
                    if ($clientsContract['ClientsContract']['active']==0)
                    {

                        $class = null;
                        if ($i % 2 == 0) {
                            $class = ' class="altrow"';
                        }
                        echo '<div class="contract_list" id='.$clientsContract['ClientsContract']['id'].'>';
                        echo $this->element('contract_view_inactive', array(
                                'clientsContract'=>$clientsContract,
                                'webroot'=>$this->webroot,
                                'i'=>$i++,
                                'class'=>$class,
                                ));
                        echo '</div>';

                    }
                endforeach;
    ?>
    </table>
