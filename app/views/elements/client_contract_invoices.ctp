<?php

	function clients_contracts_invoices_view($invoices,$next,$print=0)
	{
		$basedir = $this->webroot;
$html_result = '<table border=1>
    <tr>
        <th>id</th>
        <th>Employee</th>
        <th></th>
        <th>Period</th>
        <th>Date</th>
        <th>Terms</th>
        <th>DueDate</th>
        <th>Amount</th>
        <th>Payments</th>
        <th>Balance</th>
    </tr>';
    // Define $color=1
    $color="1";
    $totalsales = 0;
    $totalbalance = 0;

    foreach ($invoices['XML_Serializer_Tag'] as $inv)
    {
    //debug($inv);exit;
    if (isset($inv['Invoice']['amount']))
    $totalsales += $inv['Invoice']['amount'];
    if (isset($inv['Invoice']['balance']))
    $totalbalance += $inv['Invoice']['balance'];
    // If $color==1 table row color = #FFC600
    if($inv['Invoice']['balance']>.01)
    {
    if($color==1){

    if (!$print)
    {
    $html_result .= '<tr bgcolor="#FFC600">';
    } else
    {
    $html_result .= '<tr bgcolor="white">';

    }
    $html_result .= $this->invindexlineout($inv,$basedir,$print,$next);
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
    $html_result .= $this->invindexlineout($inv,$basedir,$print,$next);
    $html_result .= '</tr>';
    $color="1";
    }
    }
    }
    $html_result .= '	</table><br>';
    $html_result .= '	Total Sales='.sprintf('%8.2f',round($totalsales,2)).'<br>';
    $html_result .= '	Total Open='.sprintf('%8.2f',round($totalbalance,2)).'<br>';

    return $html_result;
}

echo clients_contracts_invoices_view($invoices,$next);