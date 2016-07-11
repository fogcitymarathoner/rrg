<?php
        

   function statementlineout($inv,$totalbalance,$basedir,$print,$next)
    {
            $html_result = '';
            $html_result .= '<td>'.date('m/d/Y',strtotime($inv[0])).'</td>';
$html_result .= '<td >'.$inv[1].'</td>';
$html_result .= '<td >'.$inv[5].'</td>';
$html_result .= '<td align="right">'.
    sprintf('%8.2f',round($inv[2],2))
    .'</td>';
$html_result .= '<td align="right">'.
    sprintf('%8.2f',round($totalbalance,2))
    .'</td>';
return $html_result;

}
function client_open_statement_view($items,$next,$print=0,$webroot)
    {
        $basedir = $webroot;
$html_result = '<table border=1>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Date Due</th>
        <th>Amount</th>
        <th>Balance</th>
    </tr>';
    // Define $color=1
    $color="1";
    $totalsales = 0;
    $totalbalance = 0;

    foreach ($items as $inv)
    {
    // skip cleared [4] and voided [7] and checks where [1] contains 'check'
    if(!$inv[4] && !$inv[7] && !substr_count ($inv[1],'check'))
    {
    if (isset($inv[2]))
    $totalbalance += $inv[2];
    if (isset($inv[2]) && $inv[2]>0)
    $totalsales += $inv[2];
    // If $color==1 table row color = #FFC600
    if($color==1){

    if (!$print)
    {
    $html_result .= '<tr bgcolor="#FFC600">';
    } else
    {
    $html_result .= '<tr bgcolor="white">';

    }
    $html_result .= statementlineout($inv,$totalbalance,$basedir,$print,$next);
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
    $html_result .= statementlineout($inv,$totalbalance,$basedir,$print,$next);
    $html_result .= '</tr>';
    $color="1";
    }
    }
    }
    $html_result .= '	</table><br>';
$html_result .= '	Total Open='.sprintf('%8.2f',round($totalbalance,2)).'<br>';

return $html_result;
}

        echo  client_open_statement_view($items,$next,$print,$webroot);