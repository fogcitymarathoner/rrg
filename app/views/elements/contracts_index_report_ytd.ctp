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
	function client_contracts_view($contracts,$active=1,$webroot)
	{
		$janonethisyear = mktime(0,0,0,0,0,date('Y'));
		$res ='';
		$res .='<h3>Contracts';
		if ($active == 1)
		{
			$res .= ' (Active)';
		}
		else
		{
			$res .= ' (Inactive)';
		}
		$res .='</h3>';
		if (!empty($contracts))
		{
			$res .='<table cellpadding = "1" cellspacing = "1" border ="1">';
			$res .='<tr>';
			$res .='<th>ID</th>';
			$res .='<th>Employee Name</th>';
			$res .='<th>Reports To</th>';
			$res .='<th>Start Date</th>';
			$res .='<th>Title</th>';
			$res .='<th>Bill Out</th>';
			$res .='<th>YTD</th>';
			$res .='</tr>	';
			$i = 0;	
			foreach ($contracts as $clientsContract): 
				if ($clientsContract['active']==$active)
				{
				//debug($clientsContract['Invoice']);exit;
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
					$res .= '<TR '.$class.'>';
					$res .= '<td>';
					$res .= $clientsContract['id'];					
					$res .= "</td>";
					$res .= '<td>';
					$res .= $clientsContract['Employee']['firstname'].' '.$clientsContract['Employee']['lastname'];					
					$res .= "</td>";
					$res .= '<td>';//debug($clientsContract);
					$res .= $clientsContract['reports_to'];					
					$res .= "</td>";
					$res .= '<td>';
					$res .= $clientsContract['startdate'];					
					$res .= "</td>";
					$res .= '<td>';
					$res .= $clientsContract['title'];					
					$res .= "</td>";
					$res .= '<td>';
                    if(!empty($clientsContract['ContractsItem']))
					    $res .= $clientsContract['ContractsItem'][0]['description'].': '.sprintf('%8.2f',round($clientsContract['ContractsItem'][0]['amt'],2)).': ';
					$res .= "</td>";
					$res .= '<td align=right>';
					
					$ytd = 0;
					foreach($clientsContract['Invoice'] as $invoice)
					{
						if (isset($invoice['paid_date']) && $invoice['paid_date'] != NULL)
						{
							$date_paidA = split('-', $invoice['paid_date']);
							$paid_time = mktime(0,0,0, $date_paidA[1],$date_paidA[2],$date_paidA[0]);
							
							if($invoice['voided']==0 && $invoice['cleared']==1 && $paid_time >=$janonethisyear )
							{
								$ytd += $invoice['amount'];
							}
						}
					//debug($invoice);
					}
					
					$res .= sprintf('%8.2f',round($ytd,2));
					$res .= "</td>";
					$res .= "</tr>";
					$res .= "<tr>";
					$res .= '<td colspan = 5>';
					$res .= $clientsContract['notes'];					
					$res .= "</td>";
					$res .= "</tr>";
				}
			endforeach; 
			$res .='</table>';
		}
		return $res;
	}
	
?>
<?php 
echo date("F j, Y, g:i a");
echo client_contracts_view($contracts,$active,$webroot) ?>
