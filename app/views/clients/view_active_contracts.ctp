<?php
echo $javascript->link('clients_view');?>

<?php echo $this->element('clients/menu', array('client'=>$contracts['Client'],	)); ?>
<br>		
<br>		<h3><?php echo $page_title; ?></h3>

<?php echo $this->element('client/address_info',array('client'=>$this->data['Client'],'webroot'=>$this->webroot)); ?>
	<!-- Active Contracts -->
	<?php echo $html->link(__('New Contract For Client', true), array('action'=>'add_contract',$contracts['Client']['id'])); ?>

	<?php echo $html->link(__('Printable', true), array('action'=>'view_active_contracts_printable/'.$contracts['Client']['id'])); ?>

	<?php echo $html->link(__('Printable YTD', true), array('action'=>'view_active_contracts_printable_ytd/'.$contracts['Client']['id'])); ?>

	<?php echo $html->link(__('Pending Addendums', true), array('action'=>'view_active_contracts_pending_printable/'.$contracts['Client']['id'])); ?>

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
			foreach ($contracts['ClientsContract'] as $clientsContract):
				if ($clientsContract['active']==1)
				{
					
					$class = null;
					if ($i % 2 == 0) {
						$class = ' class="altrow"';
					}
					echo '<div class="contract_list" id='.$clientsContract['id'].'>';
					echo $this->element('contract/view', array('clientsContract'=>$clientsContract,'webroot'=>$this->webroot,'i'=>$i++,'class'=>$class,));
					echo '</div>';

				}
			endforeach; 
?>
</table>
