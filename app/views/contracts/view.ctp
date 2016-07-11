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
					
    echo $javascript->link('clients_view');
    $this->data['ClientsContract']['Employee'] = $this->data['Employee'];
    $this->data['ClientsContract']['ContractsItem'] = $this->data['ContractsItem'];
    echo $this->element('contract/view', array('clientsContract'=>$this->data['ClientsContract'],'webroot'=>$this->webroot,'i'=>0,'class'=>null,));

?>
