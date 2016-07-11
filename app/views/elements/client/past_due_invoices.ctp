<?php

	function dateDiff($startDate, $endDate)
	{
	    // Parse dates for conversion
	    $startArry = getdate(strtotime($startDate));
	    $endArry = getdate(strtotime($endDate));

	    // Convert dates to Julian Days
	    // $start_date = gregoriantojd(date('m',strtotime($startArry["month"])), $startArry["mday"], $startArry["year"]);
	    // $end_date = gregoriantojd(date('m',strtotime($endArry["month"])), $endArry["mday"], $endArry["year"]);

	    // Return difference
	    // return round(($end_date - $start_date), 0);
	    return(0);
	}
    function invpastdueindexlineout($inv,$basedir,$print,$next,$webroot)
   	{
   			$invnumbersplit = split('#',$inv[1]);
   			$html_result = '<td align="left"><a href="'.$webroot.'clients/view_invoice/'.$invnumbersplit[1].'/next:'.$next.'" >'.$invnumbersplit[1].'</a></td>';

$html_result .= '<td colspan="2" >';
    if($inv[12] != '')
    {
    $html_result .= $inv[12];
    }
    $html_result .= '</td>';
if($inv[10] != '')
{
$html_result .= '<td align="right" >'.
    date('m/d/Y',strtotime($inv[10])).'-'.
    date('m/d/Y',strtotime($inv[11])).
    '</td>';
}	else {
$html_result .= '<td align="right" ></td> ';
}
$html_result .= '<td>'.date('m/d/Y',strtotime($inv[0])).'</td>';
$html_result .= '<td align=center>'.$inv[3].'</td>';
$html_result .= '<td>'.date('m/d/Y',strtotime($inv[5])).'</td>';

$dayspast = dateDiff($inv[5],date('Y-m-d'));
$html_result .= '<td align=center>'.$dayspast.'</td>';
$html_result .= '<td align="right">'.
    sprintf('%8.2f',round($inv[2],2))
    .'</td>';
if (isset($inv['Invoice']['payments']))
{
$html_result .= '<td align="right">'.sprintf('%8.2f',round($inv['Invoice']['payments'],2)).'</td>';
} else {

$html_result .= '<td align="right">'.sprintf('%8.2f',0).'</td>';
}
if (isset($inv['Invoice']['balance']))
{
$html_result .= '<td align="right">'.sprintf('%8.2f',round($inv['Invoice']['balance'],2)).'</td>';
} else {
$html_result .= '<td align="right">'.sprintf('%8.2f',0).'</td>';
}


if (!$print)
{
    $html_result .= '<td><a href="'.$webroot.'clients/edit_invoice/'.$invnumbersplit[1].'/next:'.$next.'" >Edit</a></td>';
    $html_result .= '<td><a href="#" onclick="openWindow(\''.$webroot.'clients/view_invoice_pdf/'.$invnumbersplit[1].'\')">Preview</a></td>';
}
return $html_result;

}

                
    function clients_contracts_invoices_pastdue_view($invoices,$print=0,$next,$webroot)
	{
		$basedir = $webroot;
if (!$print)
{
$html_result = '<table>';
    } else
    {
    $html_result = '<table cellpadding="0" cellspacing="0" border=1>';
        }
        $html_result .= '<tr>
            <th>id</th>
            <th>Employee</th>
            <th></th>
            <th>Period</th>
            <th>Date</th>
            <th>Terms</th>
            <th>DueDate</th>
            <th>days Past Due</th>
            <th>Amount</th>
            <th>Payments</th>
            <th>Balance</th>
        </tr>';
        // Define $color=1
        $color="1";
        $total = 0;
        foreach ($invoices as $inv)
        {
        $epoch_duedate = mktime(0,0,0, date("m",strtotime($inv[5])),date("d",strtotime($inv[5])),date("Y",strtotime($inv[5])));
        $now = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        //debug($epoch_duedate);debug($now);exit;
        if ($inv[5] && $inv[0]>0.02)
        {
        if($epoch_duedate 	<= $now)
        {
        $total += $inv[2];
        if($color==1){
        if (!$print)
        {
        $html_result .= '<tr bgcolor="#FFC600">';
            } else
            {
            $html_result .= '<tr bgcolor="white">';

            }
            $html_result .= invpastdueindexlineout($inv,$basedir,$print,$next,$webroot);
            $html_result .= '</tr>';
        // Set $color==2, for switching to other color
        $color="2";
        }

        // When $color not equal 1, use this table row color
        else {
        if (!$print)
        {
        $html_result .= '<tr bgcolor="#C6FF00">';
            } else
            {

            $html_result .= '<tr bgcolor="#EFEFEF">';
            }
            $html_result .= invpastdueindexlineout($inv,$basedir,$print,$next,$webroot);
            $html_result .= '</tr>';
        $color="1";
        }
        }
        }
        }
        $html_result .= '	</table><br>';
    $html_result .= '	Total pastdue='.sprintf('%8.2f',round($total,2)).'<br>';

    return $html_result;
    }
echo clients_contracts_invoices_pastdue_view($invoices,$print,$next,$webroot);