<?php
        
	function invpendinglineout($inv,$basedir,$next,$webroot)
	{
			$html_result = '<td align="left"><a href="'.$webroot.'clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >'.$inv['Invoice']['id'].'</a></td>';

$html_result .= '<td colspan="2" >';
    if($inv['ClientsContract']['employee_id'] != '')
    {
    $html_result .= $inv['ClientsContract']['Employee']['firstname'].' '.$inv['ClientsContract']['Employee']['lastname'];
    }
    $html_result .= '</td>';
if($inv['Invoice']['period_start'] != '')
{
$html_result .= '<td align="right" >'.
    date('m/d/Y',strtotime($inv['Invoice']['period_start'])).'-'.
    date('m/d/Y',strtotime($inv['Invoice']['period_end'])).
    '</td>';
}	else {
$html_result .= '<td align="right" ></td> ';
}
$html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['date'])).'</td>';
$html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['duedate'])).'</td>';
$html_result .= '<td align="right">'.
    sprintf('%8.2f',round($inv['Invoice']['amount'],2))
    .'</td>';
$html_result .= '<td><a href="'.$webroot.'clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >Edit</a></td>';

$html_result .= '<td><a href="'.$webroot.'clients/push_invoice_to_timecards/'.$inv['Invoice']['id'].'" >Push To Timecards</a></td>';
return $html_result;

}
    function clients_contracts_pending_invoices_view($invoices,$next, $webroot)
	{
	$basedir = $webroot;
$html_result = '<table>
    <tr>
        <th>id</th>
        <th>Employee</th>
        <th></th>
        <th>Period</th>
        <th>Date</th>
        <th>DueDate</th>
        <th>Amount</th>
    </tr>';
    // Define $color=1
    $color="1";
    foreach ($invoices as $inv)
    {
    if($inv['Invoice']['timecard']== 1 && $inv['Invoice']['posted']== 0 && $inv['Invoice']['voided']== 0)
    {
    if($color==1){
    $html_result .= '<tr bgcolor="#FFC600">';
    $html_result .= invpendinglineout($inv,$basedir,$next,$webroot);
    $html_result .= '</tr>';
    // Set $color==2, for switching to other color
    $color="2";
    }

    // When $color not equal 1, use this table row color
    else {
    $html_result .= '<tr bgcolor="#C6FF00">';
    $html_result .= invpendinglineout($inv,$basedir,$next,$webroot);
    $html_result .= '</tr>';
    $color="1";
    }
    }
    }
    $html_result .= '	</table><br>';

return $html_result;
}

echo clients_contracts_pending_invoices_view($invoices,$next, $webroot);