

<?php
	function reminders($reminders, $webroot)
	{	
		$html = new HtmlHelper;
		$res = '<div style=" display: block; float:left"><h2 >Timecard Reminders</h2>
		<table cellpadding = "3" cellspacing = "3" border=1 >
			<tr>
			<th>Client</th>
			<th colspan=2>Employee</th>
			<th>Period</th>
			<th></th>
			<th></th>
			<th></th>
			</tr> ';
			if (!empty($reminders))
			{	$i = 0;
				foreach($reminders as $invoice): 
			
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
						$res .= '<tr '.$class. '>';
			            $res .= '<td colspan="1" ><a href="'.
			            $webroot.
			            '/clients/view/'.
			            $invoice['ClientsContract']['Client']['id'].'">'.$invoice['ClientsContract']['Client']['name'].'</a></td><td colspan="2" >';
						if ($invoice['ClientsContract']['employee_id'])
						{
							$class = '';
							if (!$invoice['ClientsContract']['Employee']['active'])
								$class = 'inactive-employee';
							$res .=  '<b><a href="'.$webroot.'employees/view_paychecks_due/'.$invoice['ClientsContract']['Employee']['id'].
        '" class="'.$class.'">'.$invoice['ClientsContract']['Employee']['firstname'].' ';
							if($invoice['ClientsContract']['Employee']['nickname']!='')
							{
								$res .=  '('.$invoice['ClientsContract']['Employee']['nickname'].') ';
							}
							$res .=  $invoice['ClientsContract']['Employee']['lastname'].'</a></b><br>';
							if(count($invoice['EmployeeEmail']))
							{
								foreach ($invoice['EmployeeEmail'] as $email)
								{
									$res .=  $email['EmployeesEmail']['email'].'<br>';
								}
							} else{
								$res .=  'NO EMPLOYEE EMAILS';
							}
							if(count($invoice['InvoicesTimecardReminderLog']))
							{
								foreach ($invoice['InvoicesTimecardReminderLog'] as $log)
								{
									$res .=  $log['InvoicesTimecardReminderLog']['email'].':<br>'.$log['InvoicesTimecardReminderLog']['timestamp'].'<br>';
								}
							} else
							{
								$res .=  'NO EMPLOYEE REMINDERS EMAILED';
							}
						}
						
						$res .= '</td>';
						if($invoice['Invoice']['period_start'])
						{
							$res .= '<td align="right" ><b><div class="reminder-date">';
			           		$res .=  date('m/d/Y', strtotime($invoice['Invoice']['period_start'])).'</div><div class="reminder-date-hyphen">to</div><div class="reminder-date">'.date('m/d/Y', strtotime($invoice['Invoice']['period_end'])).'</div>';
							$res .= '</b></td>';
						} else {
							$res .= '<td align="right" ></td> ';       
						} 
						if($invoice['Invoice']['emailenable'])
						{
							$res .= '<td align="right" >';
			           		$res .= '<a href="'.$webroot.'reminders/email/'.$invoice['Invoice']['id'].'">email</a></td>';
						} else { 
							$res .= '<td align="right" >email</td>';  
						 }
					   $res .= '<td align="left">';
					   
$res .= '<form name=xx autocomplete="off" class="user_data_form">';
if ($invoice['Invoice']['voided'] == 0)
{ 
$res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_timecard(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" value="Voided"> Timecard Received
<br>
<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_timecard(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" 
value="Unvoided" checked> Timecard Not Received';
} else {
$res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_timecard(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" 
value="Willing" checked> Timecard Received
<br?
<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_timecard(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" 
value="Unvoided"> Timecard Not Received';
}
$res .= '</form></td>';
					   //$res .= '<a href="'.$webroot.'reminders/transition_timecard/'.$invoice['Invoice']['id'].'">timecard</a></td>';
					   $res .= '<td align="left">';
					   
$res .= '<form name=xx autocomplete="off" class="user_data_form">';
if ($invoice['Invoice']['voided'] == 0)
{ 
$res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" value="Voided"> Voided
<br>
<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" 
value="Unvoided" checked> Unvoided';
} else {
$res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" 
value="Willing" checked> Voided
<br>
<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" 
value="Unvoided"> Unvoided';
}
$res .= '</form></td>';
					   				//$res .= '<a href="'.$webroot.'reminders/transition_void/'.$invoice['Invoice']['id'].'">void</a></td>';
					   $res .= '</tr>';
					   
						$res .= '<tr '.$class. '>';
				   		$res .= '<td colspan=6>';
				   		$res .= '<a href="'.$webroot.'reminders/edit_notes/'.$invoice['Invoice']['id'].'/index">edit notes</a>   ';
				   		$res .= $invoice['Invoice']['notes'];
				   		$res .= '</td></tr>';
					endforeach; 
			} else { 
		        $res .= '<tr>
		            <td colspan="2">No records</td>
		        </tr> 	';
			}	
		$res .= '</table></div>';
		return $res;        

	}

?>
<?php echo reminders($reminders,$webroot) ?>
